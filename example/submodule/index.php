<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  page::start();
  sidebar::start('example');
  panel::dashboard('example');
  sidebar::end();
  page::end();

?>