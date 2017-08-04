<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  header('Content-Type: text/plain');
  foreach (scandir(BASE) as $item) {
    if (is_dir(BASE.DIRECTORY_SEPARATOR.$item) && $item != '.') {
      if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.'config.json')) {
        $tmp = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.'config.json'));
        cron::check($tmp, BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR);
      }
      foreach (scandir(BASE.DIRECTORY_SEPARATOR.$item) as $subitem) {
        if (is_dir(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem) && $subitem != '.' && $item != 'core') {
          if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.'config.json')) {
            $tmp = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.'config.json'));
            cron::check($tmp, BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR);
          }
        }
      }
    }
  }
  
?>