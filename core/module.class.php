<?php
  
class module
{
  private static $config = 'config.json';

  public static function read()
  {
    $tmp = array();
    foreach (scandir(BASE) as $item) {
      if (is_dir(BASE.DIRECTORY_SEPARATOR.$item) && $item != '.') {
        if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.module::$config)) {
          $module = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.module::$config));
          $module->path = BASE.DIRECTORY_SEPARATOR.$item;
          $tmp[$module->id] = $module;
        }
        foreach (scandir(BASE.DIRECTORY_SEPARATOR.$item) as $subitem) {
          if (is_dir(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem) && $subitem != '.' && $item != 'core') {
            if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.module::$config)) {
              $module = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.module::$config));
              $module->path = BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem;
              $tmp[$module->id] = $module;
            }
          }
        }
      }
    }
    return $tmp;
  }
      
  public static function selfread()
  {
    if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.module::$config)) {
      $output = json_decode(file_get_contents(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.module::$config));
      $output->path = dirname($_SERVER['SCRIPT_FILENAME']);
      return $output;
    } else {
      return null;
    }
  }
}
  
?>