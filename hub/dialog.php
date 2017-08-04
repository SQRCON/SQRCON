<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'navright':
      echo '<button type="button" class="btn btn-primary" style="margin-top: 7px">'.rb::get('hub.create', array('<span class="fa navbar-fa fa-plus" aria-hidden="true"></span>')).'</button>';
      break;
    default:
      network::error('invalid action - '.network::get('action'));
      break;
  }
}

?>