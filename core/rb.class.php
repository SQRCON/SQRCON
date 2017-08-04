<?php

class rb
{
  private static $defaultlanguage = 'en';

  public static function get($index, $variables = array())
  {
    $tmp = explode('.', $index);
    if (sizeof($tmp) == 2) {
      if ($tmp[0] == 'core') {
        if (file_exists(CORE.DIRECTORY_SEPARATOR.'core.'.substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).'.txt')) {
          $lang = json_decode(file_get_contents(CORE.DIRECTORY_SEPARATOR.'core.'.substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).'.txt'), true);
          if (isset($lang[$tmp[1]])) {
            return rb::parse($lang[$tmp[1]], $variables);
          } else {
            return $index;
          }
        } else if (file_exists(CORE.DIRECTORY_SEPARATOR.'core.'.rb::$defaultlanguage.'.txt')) {
          $lang = json_decode(file_get_contents(CORE.DIRECTORY_SEPARATOR.'core.'.rb::$defaultlanguage.'.txt'), true);
          if (isset($lang[$tmp[1]])) {
            return rb::parse($lang[$tmp[1]], $variables);
          } else {
            return $index;
          }
        } else {
          return $index;
        }
      } else {
      
      }
    } else {
      return $index;
    }
  }
  
  private static function parse($message, $variables)
  {
    foreach ($variables as $key => $value) {
      $message = str_replace('{'.$key.'}', $value, $message);
    }
    return $message;
  }
}

?>