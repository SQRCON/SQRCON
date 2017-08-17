<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

cron::start();
echo $_GET['msg'].PHP_EOL;
cron::end();

?>