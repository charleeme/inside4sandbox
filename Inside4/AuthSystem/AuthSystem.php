<?php

namespace Inside4\AuthSystem;

use Inside4\AuthSystem\FacebookLogin as FacebookLogin;

Class AuthSystem {

    var $logged_in;
    var $users_table = 'auth_users';
    var $user;
    var $fb_login;
    var $google_login;

    // Dependencies
    var $website;
    var $security;
    var $sessions;
    var $view;
    var $mailer;
    var $db;


    public function init(){

        // Get User Data to $this->user if Session is Logged In
        if ($this->sessions->session_data['user_id'] > 0) {
            $this->user = $this->get_user($this->sessions->session_data['user_id']);
            $this->logged_in = true;
        } else {
            $this->user = false;
            $this->logged_in = false;
        }

        $this->fb_login = new FacebookLogin();
        $this->fb_login->set_config($this->website->config['facebook']);
        $this->fb_login->init();

        $this->google_login = new GoogleLogin();
        $this->google_login->set_config($this->website->config['google']);
    }

    public function is_logged_in(){
        return $this->logged_in;
    }

    public function email_check($email){

        $email = $this->db->quote($email);
        $query = "SELECT id FROM ".$this->users_table." WHERE email = {$email} LIMIT 1";
        $data = $this->db->sql_get_data($query);

        $res = false;
        if (isset($data[0]['id'])) $res = true;

        return $res;
    }


    public function login($email, $password){

        $user_id = false;

        $password = $this->security->encrypt_secure_static($password);
        $password = md5(md5($password));

        // try_login
        $query = "SELECT 
                    id, email, phone, username, is_verified_email, is_verified_phone, img
                    FROM ".$this->users_table." 
                    WHERE email = ".$this->db->quote($email)." AND password = ".$this->db->quote($password)." LIMIT 1
        ";
        $data = $this->db->sql_get_data($query);

        // print_r($query);

        if (isset($data[0]['id'])) {
            $this->user = $data[0];
            $user_id = $this->user['id'];

            // make session
            $this->sessions->add_user_to_session($user_id);
            $this->sessions->track_activity('login user #'.$user_id);

        }

        return $user_id;
    }

    public function login_trusted($email, $from){
        $user_id = false;

        // try_login
        $query = "SELECT 
                    id, email, phone, username, is_verified_email, is_verified_phone, img
                    FROM ".$this->users_table." 
                    WHERE email = ".$this->db->quote($email)." LIMIT 1
        ";
        $data = $this->db->sql_get_data($query);

        // print_r($query);

        if (isset($data[0]['id'])) {
            $this->user = $data[0];
            $user_id = $this->user['id'];

            // make session
            $this->sessions->add_user_to_session($user_id);
            $this->sessions->track_activity($from.' login user #'.$user_id);

        }

        // Send Password to Email !!!
        // >>>>>>>>>> Or HOW User Know his Email ???

        return $user_id;
    }

    public function logout(){

        $user_id = $this->user['id'];
        $this->sessions->remove_user_from_session();
        $this->sessions->track_activity('logout user #'.$user_id);

    }

    public function register_from_social($email, $data, $from){

        $user_id = false;

        $password_pure = $this->security->generateRandomString('8');

        $password = $this->security->encrypt_secure_static($password_pure);
        $password = md5(md5($password));

        $data['email'] = $email;
        $data['password'] = $password;

        $this->db->insert($this->users_table, $data);
        $user_id = $this->db->last_id();

        $this->sessions->add_user_to_session($user_id);
        $this->sessions->track_activity($from.' register user #'.$user_id);

        // Send to Email
        $data['header'] = "Register User from Social Login";
        $data['content'] = 'Dear User #'.$user_id." thx for register, your password is: <b>".$password_pure."</b>";
        $data['footer'] = $this->website->config['mailer']['footer'];

        $message = $this->view->render_to_var($data, 'Mail/mail_template.php');

        $subject = "Register User from Social Login";
        $this->mailer->send_email($email, $message, $subject);

        $this->sessions->track_activity('send new password for social login user #'.$user_id);

        return $user_id;

    }

    public function register($email, $password, $data){

        $user_id = false;

        $password = $this->security->encrypt_secure_static($password);
        $password = md5(md5($password));

        $data['email'] = $email;
        $data['password'] = $password;

        $this->db->insert($this->users_table, $data);
        $user_id = $this->db->last_id();

        $this->sessions->add_user_to_session($user_id);
        $this->sessions->track_activity('register user #'.$user_id);

        return $user_id;

    }

    public function password_recovery($email){

        // Generate Recovery Code
        $random_ready = false;
        $random = '';
        $encrypted_random = '';

        while (!$random_ready) {

            // Random
            $random = (time()).(floor(microtime(1)*10000)).$this->security->generateRandomString('16');
            $encrypted_random = $this->security->encrypt_secure_static($random);
            $encrypted_random = md5($encrypted_random);
            $query = "SELECT 
                    id FROM ".$this->users_table." 
                    WHERE pass_recovery_code = ".$this->db->quote($encrypted_random)." LIMIT 1
        ";
            $data = $this->db->sql_get_data($query);
            // Random Check
            if (!isset($data[0]['id'])) $random_ready = true;
        }

        $query = "SELECT 
                    id, email, username FROM ".$this->users_table." 
                    WHERE email = ".$this->db->quote($email)." LIMIT 1
        ";
        $data_user = $this->db->sql_get_data($query);

        $update_data['pass_recovery_code'] = $encrypted_random;
        $this->db->update($this->users_table, $update_data, 'WHERE id = '.intval($data_user[0]['id']));

        // Send to Email
        $data['header'] = "Password Recovery Link";
        $data['content'] = "Your recovery link: <a href='".$this->website->config['main']['base_url']."/auth/generate_new_password/?code=".urlencode($random)."'>Click for get a NEW password &gt;&gt;&gt;</a>";
        $data['footer'] = $this->website->config['mailer']['footer'];

        $message = $this->view->render_to_var($data, 'Mail/mail_template.php');

        $subject = "Password Recovery for ".$email;
        $this->mailer->send_email($email, $message, $subject);

        $this->sessions->track_activity('send recovery code to user #'.$data_user[0]['id']);

        return true;

    }

    public function change_password($old_password, $new_password){

        $res = false;

        $password = $this->security->encrypt_secure_static($old_password);
        $password = md5(md5($password));

        $query = "SELECT id FROM ".$this->users_table." WHERE password = ".$this->db->quote($password)." AND id = ".intval($this->user['id'])." LIMIT 1";
        $data = $this->db->sql_get_data($query);

        if (isset($data[0]['id'])) {
            $password = $this->security->encrypt_secure_static($new_password);
            $password = md5(md5($password));
            $this->db->update($this->users_table, Array('password' => $password), 'WHERE id = '.intval($data[0]['id']));
            $res = true;
        }


        return $res;
    }

    public function check_password_recovery_code($code){

        $code = $this->security->encrypt_secure_static($code);
        $code = md5($code);
        $query = "SELECT id, email, username FROM ".$this->users_table." WHERE pass_recovery_code = ".$this->db->quote($code)." AND pass_recovery_code != '' LIMIT 1";
        $data = $this->db->sql_get_data($query);

        $res = false;
        if (isset($data[0]['id'])) {
            $res = true;

            $password_pure = $this->security->generateRandomString('8');
            $password = $this->security->encrypt_secure_static($password_pure);
            $password = md5(md5($password));

            $update_data['pass_recovery_code'] = '';
            $update_data['password'] = $password;
            $this->db->update($this->users_table, $update_data, 'WHERE id = '.intval($data[0]['id']));

            // Send to Email
            $data['header'] = "Password Recovery Link";
            $data['content'] = "Your new password: <b>".$password_pure."</b>";
            $data['footer'] = $this->website->config['mailer']['footer'];

            $message = $this->view->render_to_var($data, 'Mail/mail_template.php');

            $subject = "Password Recovery for ".$data[0]['email'];
            $this->mailer->send_email($data[0]['email'], $message, $subject);

            $this->sessions->track_activity('send new password for user #'.$data[0]['id']);
        }

        return $res;
    }

    public function social_login($email, $data, $social_network_name){

        $res = Array();
        $res['login_type'] = false;

        if (isset($email)) {

            if (!$this->email_check($email)) {

                if ($this->register_from_social($email, $data, 'social '.$social_network_name)) {

                    // $this->mailer->send_reg_email($email);

                    $message = 'Social Registration Success';
                    $res['message'] = $message;
                    $res['login_type'] = 'register';

                } else {
                    $message = 'Registration Error';
                };
            }
            else {
                $this->login_trusted($email, 'social '.$social_network_name);
                $message = 'Social Login Success';
                $res['login_type'] = 'login';
            }
        } else {
            $message = 'No Email in you Social Account!';
        }

        $res['message'] = $message;

        return $res;
    }

    public function get_user($user_id){

        // Load user from session token
        // Generate a NEW token

        $query = "SELECT 
                    id, email, phone, username, is_verified_email, is_verified_phone, img
                    FROM ".$this->users_table." WHERE id = ".intval($user_id)." LIMIT 1
        ";
        $data = $this->db->sql_get_data($query);

        $user = $data[0];

        return $user;

    }
    public function update_user_data($data, $user_id){

        $this->db->update($this->users_table, $data, 'WHERE id = '.intval($user_id));
        return true;
    }
    public function is_admin(){

        return true;
    }

    public function email_verification_code($code) {
        $res = false;
        $query = "SELECT 
                    id
                    FROM ".$this->users_table." WHERE email_verify_code = ".intval($code)." AND email_verify_code != '' LIMIT 1
        ";
        $data = $this->db->sql_get_data($query);

        if (isset($data[0]['id'])) {
            $res = true;
            $this->db->update($this->users_table, Array('is_verified_email' => 1, 'email_verify_code' => ''), 'WHERE id = '.intval($data[0]['id']));
            $this->sessions->track_activity('email verified by user #'.$data[0]['id']);
        }

        return $res = true;
    }
    public function send_email_verification_code($user) {

        $code = $this->security->generateRandomString_unique($this->users_table, 'email_verify_code');
        $this->db->update($this->users_table, Array('email_verify_code' => $code), 'WHERE id = '.intval($user['id']));
        // Send to Email
        $data['header'] = "Email Verification Link";
        $data['content'] = "<a href='".$this->website->config['main']['base_url']."/auth/email_verification_code/?code=".urlencode($code)."'>&gt;&gt; Click here for validate Email &lt;&lt;</a>";
        $data['footer'] = $this->website->config['mailer']['footer'];
        $message = $this->view->render_to_var($data, 'Mail/mail_template.php');
        $subject = "Email Verification for ".$user['email'];
        $this->mailer->send_email($user['email'], $message, $subject);

        $this->sessions->track_activity('send email verification user #'.$user['id']);

        return true;
    }



}