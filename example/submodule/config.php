<?php

  require_once(dirname(realpath(__DIR__)).DIRECTORY_SEPARATOR.'config.php');
  
  $controller = CONTEXT.URL_SEPARATOR.basename(dirname(__DIR__)).URL_SEPARATOR.basename(__DIR__).URL_SEPARATOR.'controller.php';
  $dialog = CONTEXT.URL_SEPARATOR.basename(dirname(__DIR__)).URL_SEPARATOR.basename(__DIR__).URL_SEPARATOR.'dialog.php';

?>