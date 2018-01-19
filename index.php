<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'wrapper.php');
  
  page::start();
  dashboard::construct();
  page::end();

?>