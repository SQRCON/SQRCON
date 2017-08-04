<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'common.php');
  
  page::start();
  foreach ($_SESSION as $key => $value)
  {
    echo $key."=".$value."<br>";
  }
  page::end();

?>