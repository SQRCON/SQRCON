<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  page::start();
  panel::dashboard('user');
  
  $id = -1;
  foreach ($_GET as $key => $value) {
    if ($value == '') {
      $id = $key;
      break;
    }
  }
  $user = new user($id);
  foreach ($user->read() as $key => $value) {
    echo $key.'='.$value.'<br>';
  }
  page::end();

?>