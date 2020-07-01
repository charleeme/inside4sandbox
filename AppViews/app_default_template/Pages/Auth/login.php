<div style="background: url('/Public/AppFront/app_default_template/img/bg1.jpg'); background-size:cover; background-position:center;" class="pt-4 pb-4">
	<div class="log_reg_container wblock1">
		<div class="heading_buttons">
			<div class="left_btn">
				<button type="button" class="lr_btn tab_btn login_btn active" data-target="login_block"><?=$t->get('login_h1');?></button>
			</div>
			<div class="right_btn">
				<button type="button" class="lr_btn tab_btn register_btn_login" data-target="register_block"><?=$t->get('sign_up');?></button>
			</div>
		</div>
		<div class="log_reg_conent">
			<div class="tab login_block">
				<form id="auth_form" method="POST">
					<div class="form-group">
						<label>Email</label>
						<input name="email" type="text" id="login-email" class="form-control" placeholder="<?=$t->get('enter_email_here');?>">
					</div>
					<div class="form-group">
						<label><?=$t->get('password');?></label>
						<input type="password" id="login-pass" name="password" class="form-control" placeholder="<?=$t->get('current_password');?>">
					</div>
					<div class="form-group forgot_group">
						<a class="tab_btn forgot_pass" data-target="restore_block"><?=$t->get('forget_password');?>?</a>
					</div>
					<p id="login_message" class="alert_msg"></p>
					<div class="form-group">
						<button type="button" class="btn btn-success bottom_btn" id="login-ok"><?=$t->get('login_btn');?></button>
					</div>
				</form>
			</div>
			<div class="tab register_block">
				<form id="auth_reg_form" method="POST">
					<div class="form-group">
						<label>Email</label>
						<input id="reg-email" name="email" type="text" class="form-control" placeholder="<?=$t->get('enter_email_here');?>">
					</div>
					<div class="form-group">
						<label><?=$t->get('password');?></label>
						<input id="reg-pass" name="password" type="password" class="form-control" placeholder="<?=$t->get('current_password');?>">
					</div>
					<p id="register_message" class="alert_msg"></p>
					<div class="form-group">
						<button id="reg-ok" type="button" class="btn btn-success bottom_btn"><?=$t->get('sign_up');?></button>
					</div>
				</form>
			</div>
			<div class="tab restore_block">
				<form id="auth_recovery_form" method="POST">
					<div class="form-group restore_title">
						<label><?=$t->get('pass_recovery_h1');?></label>
						<p><?=$t->get('pass_recovery_mess');?></p>
						<input id="email" name="recovery_email" type="text" class="form-control" placeholder="<?=$t->get('enter_email_here');?>">
					</div>
					<p id="recovery_message" class="alert_msg"></p>
					<div class="form-group">
						<button type="button" class="btn btn-success bottom_btn" id="instruction-ok"><?=$t->get('pass_recovery_h1');?></button>
					</div>
				</form>
			</div>
		</div>
		<!-- Soc login buttons -->
		<div class="form-group soc_group">
			<label><?=$t->get('login_with');?>:</label>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-danger" rel="nofollow" href="<?=$inside4_auth->google_login->social_login_link()?>">Google Login</a>
				</div>
                
			</div>
		</div>
	</div>
</div>