<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  page::start();
  panel::dashboard('user');
  page::end();

?>