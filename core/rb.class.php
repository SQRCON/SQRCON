<?php

class rb
{
  private static $defaultfile = 'lang';
  private static $defaultlanguage = 'en';

  public static function get($index, $variables = array())
  {
    $tmp = explode('.', $index);
    $path = BASE;
    foreach (array_slice($tmp, 0, count($tmp) - 1) as $key => $value) {
      $path .= DIRECTORY_SEPARATOR.$value;
    }
    
    if (sizeof($tmp) > 1) {
      $rb = $path.DIRECTORY_SEPARATOR.rb::$defaultfile.'.'.substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).'.txt';
      if (file_exists($rb)) {
        $bundle = json_decode(utf8_encode(file_get_contents($rb)), true);
        if (isset($bundle[$tmp[1]])) {
          return rb::parse($bundle[$tmp[1]], $variables);
        } else {
          $rb = $path.DIRECTORY_SEPARATOR.rb::$defaultfile.'.'.rb::$defaultlanguage.'.txt';
          if (file_exists($rb)) {
            $bundle = json_decode(utf8_encode(file_get_contents($rb)), true);
            if (isset($bundle[$tmp[1]])) {
              return rb::parse($bundle[$tmp[1]], $variables);
            } else {
              return $index;
            }
          } else {
            return $index;
          }
        }
      } else {
        $rb = $path.DIRECTORY_SEPARATOR.rb::$defaultfile.'.'.rb::$defaultlanguage.'.txt';
        if (file_exists($rb)) {
          $bundle = json_decode(utf8_encode(file_get_contents($rb)), true);
          if (isset($bundle[$tmp[1]])) {
            return rb::parse($bundle[$tmp[1]], $variables);
          } else {
            return $index;
          }
        } else {
          return $index;
        }
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