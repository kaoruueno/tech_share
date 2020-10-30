<?php

define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');

define('IMAGE_PATH', '/assets/images/');
define('PRE_IMAGE_PATH', '/assets/pre_images/');
define('TITLE_IMAGE_PATH', '/assets/images/title/');
define('PRE_TITLE_IMAGE_PATH', '/assets/pre_images/title/');
define('LOGO_PATH', '/assets/logo/');
define('STYLESHEET_PATH', '/assets/css/');
define('JS_PATH', '/assets/javascript/');
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/');
define('PRE_IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/pre_images/');
define('TITLE_IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/title/');
define('PRE_TITLE_IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/pre_images/title/');

define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');

define('PREVIOUS_URL', $_SERVER['HTTP_REFERER']);
define('INDEX_URL', '/index.php');
define('LOGIN_URL', '/login.php');
define('LOGOUT_URL', '/logout.php');
define('SIGNUP_URL', '/signup.php');
define('POST_URL', '/post.php');
define('POST_PRE_URL', '/post_pre.php');

define('REGEX_ALPHANUMERIC', '/^[0-9a-zA-Z]+$/');
define('REGEX_POSITIVE_INT', '/^([1-9][0-9]*|0)$/');
define('REGEX_LANGUAGE_TYPE', '/^[0-4]$/');
define('REGEX_DISPLAY_ORDER', '/^[0-1]$/');
define('REGEX_SORT_BY_OLDEST', '/^[1]$/');
define('REGEX_QUESTION_MARK', '/[\?]/');
define('REGEX_PAGE_OF_URL_PARAM', '/&*page=*[^&]*/');
define('REGEX_DUPLICATE_ANPERSAND', '/&{2,}/');
define('REGEX_WHITE_SPACE', '/[\s　]/u');
define('REGEX_ONLY_WHITE_SPACE', '/^[\s　]+$/u');
define('REGEX_BOTH_ENDS_WHITE_SPACE', '/^[\s　]*(.+?)[\s　]*$/u');
define('REGEX_DUPLICATE_WHITE_SPACE', '/[\s　]{2,}/u');
define('REGEX_IMAGE', '/\[([\w]{10})(\.png|\.jpg)\]/');

define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 20);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);

define('PERMITTED_LANGUAGE_TYPES', array(
  1 => 'HTML/CSS',
  2 => 'JavaScript',
  3 => 'PHP',
  4 => 'MySQL',
  0 => 'その他'
));

define('PROFILE_LINK', array(
  'followings' => 1,
  'followers' => 2,
  'own_posts' => 3,
  'favorite_posts' => 4,
  'favorite_languages' => 5,
  'no_request' => 0
));

define('DISPLAY_ORDER', array(
  0 => '新着順',
  1 => '投稿順'
));

define('NO_IMAGE', 'no_image.png');
?>