<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

cron::start();
echo BASE.PHP_EOL;
cron::end();

?>