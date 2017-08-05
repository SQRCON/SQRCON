<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>