<?php
    
  class auth {
  
    public static function secure()
    {
      if (!user::loggedin()) {
        auth::login();
      }
    }
     
    public static function login()
    {
      $openid = new LightOpenID($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      if(!$openid->mode) {
        $openid->identity = 'http://steamcommunity.com/openid';
        header('Location: '.$openid->authUrl());
      } elseif ($openid->mode == 'cancel') {
        // TODO
      } else {
        if($openid->validate()) { 
          $id = $openid->identity;
          $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
          preg_match($ptn, $id, $matches);
          user::construct($matches[1]);
          $tmp = explode(URL_SEPARATOR, $_SERVER['SCRIPT_NAME']);
          $query = array();
          foreach (explode('&', $_SERVER['QUERY_STRING']) as $key => $value) {
            if (substr($value, 0, 7) !== 'openid.' && $value != 'login') {
              array_push($query, $value);
            }
          }
          header('Location: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].URL_SEPARATOR.implode(URL_SEPARATOR, array_splice($tmp, 1, -1)).URL_SEPARATOR.'?'.implode('&', $query));
        }
      }
    }
    
    public static function logout()
    {
      user::deconstruct();
    }
  }
    
?>