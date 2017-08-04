<?php
  
class session
{
  public static function construct()
  {
    if (defined('COOKIE_LIFETIME')) {
      ini_set('session.cookie_lifetime', COOKIE_LIFETIME);
    }
    session_name(md5(BASE));
    session_start();
    
    if (isset($_GET['login'])) {
      auth::secure();
    }
    if (isset($_GET['logout'])) {
      auth::logout();
      session_destroy();
      $tmp = explode(URL_SEPARATOR, $_SERVER['SCRIPT_NAME']);
      $query = array();
      foreach (explode('&', $_SERVER['QUERY_STRING']) as $key => $value) {
        if ($value != 'logout') {
          array_push($query, $value);
        }
      }
      header('Location: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].URL_SEPARATOR.implode(URL_SEPARATOR, array_splice($tmp, 1, -1)).URL_SEPARATOR.'?'.implode('&', $query));
    }
  }
  
  public static function read($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return null;
    }
  }
  
  public static function write($key, $value)
  {
    $_SESSION[$key] = $value;
  }
  
  public static function delete($key)
  {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }
}
  
?>