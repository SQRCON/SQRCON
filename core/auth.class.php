<?php
    
  class auth
  {
    private static $storage = 'steamid';
  
    public static function login()
    {
      if (!user::authenicated()) {
        if (cookie::read(auth::$storage) != null) {
          user::construct(cookie::read(auth::$storage));
        } else {
          $openid = new LightOpenID($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
          if (!$openid->mode) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: '.$openid->authUrl());
          } elseif ($openid->mode == 'cancel') {
            // TODO
          } else {
            if ($openid->validate()) {
              $id = $openid->identity;
              $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
              preg_match($ptn, $id, $matches);
              
              $steamid = $matches[1];
              cookie::write(auth::$storage, $steamid);
              user::construct($steamid);
              auth::redirect('login');
            }
          }
        }
      } else {
        auth::redirect('login');
      }
    }
    
    public static function logout()
    {
      user::destroy();
      cookie::delete(auth::$storage);
      session::destroy();
      auth::redirect('logout');
    }
    
    private static function redirect($mode)
    {
      $tmp = explode(URL_SEPARATOR, $_SERVER['SCRIPT_NAME']);
      $query = array();
      foreach (explode('&', $_SERVER['QUERY_STRING']) as $key => $value) {
        if (substr($value, 0, 7) !== 'openid.' && $value != $mode) {
          array_push($query, $value);
        }
      }
      $querystring = '';
      if (sizeof($query) > 0) {
        $querystring = '?'.implode('&', $querystring);
      }
      header('Location: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].URL_SEPARATOR.implode(URL_SEPARATOR, array_splice($tmp, 1, -1)).URL_SEPARATOR.$querystring);
    }
  }
    
?>