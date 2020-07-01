// Load MAIN

let Globals_isMobile = false; // Check Mobile Device
let Globals_default_lang = 'en'; // Default Language

// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
    Globals_isMobile = true;
}

let JQuery_globals_loader_div;
let JQuery_globals_page_center;
let JQuery_globals_scripts_div;

$.ajaxSetup({cache: false});

let user_data = {};
let ttexts_data = {};
let cache_data = {};

$(document).ready(function() {

    // -------------------------- Core Script -------------------------------
    get_ttexts();
    check_user_row();

    // -------------------------- Bind Clicks ------------------------------------------

    // -------------------------- Nav -------------------------------
    $('.contacts_page_click').on('click', function(){ load_page('app_core/pages/contacts.html', false); });
    $('.main_page_click').on('click', function(){ load_page('app_core/pages/main.html', true); });
    $('.blog_list_click').on('click', function(){ load_page('app_core/pages/blog.html', true, true, true); });
    $('.agreement_link_click').on('click', function(){ load_page('app_core/pages/agreement.html', false); });


    // -------------------------- Auth Click -------------------------------
    $('.auth_click').on('click', function(){

        if (typeof user_data.username !== 'undefined') {
            load_page('app_core/pages/auth_profile.html', true, true, true);
        } else {
            load_page('app_core/pages/auth_login.html', false, true, true);
        }

    });

    $('.logout_click').on('click', function(){ log_out(); });

    JQuery_globals_loader_div =  $('#loader_div');
    JQuery_globals_page_center =  $('#page_center');
    JQuery_globals_scripts_div = $('#scripts_block');

});

function check_user_row() {

    api_call('/Auth_API/user_row_json', 'GET', function(data){

        user_data = data;
        localStorage.setItem('user_data', JSON.stringify(user_data));
        // dump_log(data);
        if (typeof data.username !== 'undefined') {
            load_page('app_core/pages/auth_profile.html', true, true, true);
        } else {
            load_page('app_core/pages/main.html', true);
        }
    });


}

function get_ttexts() {

    if (localStorage.getItem('ttexts_data')) {
        ttexts_data = JSON.parse(localStorage.getItem('ttexts_data'));
        // console.log(JSON.stringify(ttexts_data));
    } else {
        api_call('/Auth_API/get_user_app_texts', 'GET', function(data){

            ttexts_data = data;
            localStorage.setItem('ttexts_data', JSON.stringify(ttexts_data));
            // console.log(JSON.stringify(ttexts_data));
        });
    }
}

function get_ttext_val(key) {

    let lang = Globals_default_lang;
    let text;
    // alert(key);
    if (typeof ttexts_data[lang][key] !== 'undefined') {
        text = ttexts_data[lang][key];
    } else {
        text = key;
    }
    return text;

    // let text = ttexts_data.en.change_password;
    // alert(JSON.stringify(ttexts_data));
    // alert(text);
}

function fill_all_ttexts() {
    $('.ttext').each(function(){
        let alias = $(this).attr('ttext');
        if (typeof alias !== 'undefined' ) {
            $(this).html(get_ttext_val(alias));
        }

    });
}

function log_out() {

    // alert(111);
    load_page('app_core/pages/main.html', true);
    user_data = {};
    localStorage.setItem('user_data', '');
    localStorage.setItem('inside4_session', '');
    $.cookie("inside4_session", null, { path: '/' });

}

function api_call(url, method, callback_function, post_array = {}) {

    let inside4_session = encodeURIComponent(localStorage.getItem('inside4_session'));

    let api_server_url = 'http://inside4sandbox.local';

    url = api_server_url+url;

    if (method === 'GET') {

        if (url.indexOf('?') > -1)
        {
            url = url+'&inside4_session='+inside4_session;
        } else {
            url = url+'?inside4_session='+inside4_session;
        }

        $.get(url, function(data) {

            console.log(data.new_token);
            if (typeof data.new_token !== 'undefined') {
                localStorage.setItem('inside4_session', data.new_token)
            }
            callback_function(data);
        });
    } else if (method === 'POST') {

        post_array.inside4_session = localStorage.getItem('inside4_session');

        $.post(url, post_array, function(data) {

            console.log(data.new_token);
            if (typeof data.new_token !== 'undefined') {
                localStorage.setItem('inside4_session', data.new_token)
            }
            callback_function(data);
        });
    }


}

function load_page(path, loader = false, scripts = false, waiting_for_scripts = false) {

    JQuery_globals_page_center.hide();

    JQuery_globals_page_center.empty();

    if (loader) {
        JQuery_globals_loader_div.show();
    }

    close_all_before_page_load(this);

    JQuery_globals_scripts_div.empty();



    // ---------------------------- Get Body -------------------------
    $.get(path+'?_=' + new Date().getTime(), function(data){
        JQuery_globals_page_center.html(data);

        if (Globals_isMobile) {
            JQuery_globals_page_center.show('fade');
        } else {
            // Test Fade on Desktop
            JQuery_globals_page_center.show('fade');
        }

        if (waiting_for_scripts) {
            JQuery_globals_page_center.hide();
        } else {
            JQuery_globals_loader_div.hide();
        }

        if (scripts) {
            let path_scripts = path.replace('.html','_scripts.html');
            $.get(path_scripts+'?_=' + new Date().getTime(), function(data){
                JQuery_globals_scripts_div.html(data);
            });
        }

    });
    // ----------------------------------------------------------------
}

function close_all_before_page_load(click_obj) {

    setTimeout(touchSideSwipe.tssClose(), 300);

    // ------------- OLD Menu (TO DEL) ---------------
    /*
    $(click_obj).css('background', '#efe');
    setTimeout(function(){
        $(click_obj).css('background', '#eee');
    }, 200);
    $('.navbar-collapse').collapse('hide');

    */
}

function forceSWupdate () {

    if ('serviceWorker' in navigator) {
        caches.keys().then(function(cacheNames) {
            cacheNames.forEach(function(cacheName) {
                caches.delete(cacheName);
            });
        });
    }
    setTimeout(function(){
        alert('App Updated!');
        localStorage.removeItem('ttexts_data');
        window.location.reload(true);
    }, 700);
}

// Debug Function
function dump_alert(obj) {
    let out = "";
    if(obj && typeof(obj) == "object"){
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    alert(out);
};
function dump_log(obj) {
    let out = "";
    if(obj && typeof(obj) == "object"){
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    console.log(out);
};

function isScriptLoaded(src)
{
    return document.querySelector('script[src="' + src + '"]') ? true : false;
}

function loadScript(url, callback = function(){}){

    if (!isScriptLoaded(url)) {
        var script = document.createElement("script")
        script.type = "text/javascript";

        if (script.readyState){  //IE
            script.onreadystatechange = function(){
                if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = function(){
                callback();
            };
        }

        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }

}