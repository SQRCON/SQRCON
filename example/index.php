<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  page::start();
  sidebar::start('example');
  dashboard::construct('example');
  sidebar::end();
  page::end();

?>