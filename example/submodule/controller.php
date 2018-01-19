<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'init':
      $data = array(array('ID' => 1, 'VALUE1' => 'Test 1', 'VALUE2' => 'Test', 'VALUE3' => 'Test', 'VALUE4' => 'Test'),
                    array('ID' => 2, 'VALUE1' => 'Test 2', 'VALUE2' => 'Test', 'VALUE3' => 'Test', 'VALUE4' => 'Test'));
      network::data(sizeof($data), json_encode($data));
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>