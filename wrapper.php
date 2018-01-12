<?php
  define('NAME', 'SQRCON');
  define('BRAND', 'favicon-32x32.png');
  
  define('FRAMEWORK', 'cfx');
  
  define('DATABASE', 'mysql');
  define('SECURITY', 'steam_openid');
  
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.FRAMEWORK.DIRECTORY_SEPARATOR.'common.php');
  common::load(BASE.DIRECTORY_SEPARATOR.'include');
?>