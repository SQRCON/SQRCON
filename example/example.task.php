<?php

  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  file_put_contents(CACHE.DIRECTORY_SEPARATOR.'test.txt', 'TEST - '.date('l jS \of F Y h:i:s A').PHP_EOL);
  echo "Executed Example Task";

?>