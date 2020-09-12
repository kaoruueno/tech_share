<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();

if (is_logined() === true) {
  redirect_to(INDEX_URL);
}
// $token = get_csrf_token();
include_once VIEW_PATH . 'login_v.php';
?>