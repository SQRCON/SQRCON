<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'submodule':
      sidebar::renderbit('submodule', rb::get('example.submodule.name'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR.'submodule'.URL_SEPARATOR, array('icon' => 'pencil'));
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>