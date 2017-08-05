<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'setup':
      modal::start(rb::get('setup.title'), $controller.'?action=setup', 'POST', 'modal-content');
      if (!is_writeable(BASE)) {
        echo '<div class="alert alert-danger" role="alert"><b>'.rb::get('core.error').'</b> '.rb::get('setup.writable', array(BASE)).'</div>';
      }
      if (!is_writeable(CACHE)) {
        echo '<div class="alert alert-danger" role="alert"><b>'.rb::get('core.error').'</b> '.rb::get('setup.writable', array(CACHE)).'</div>';
      }
      echo '<p>'.rb::get('setup.database').'</p>';
      echo form::get(array('id' => 'database_host', 'name' => rb::get('setup.database_host'), 'validator' => 'data-fv-notempty', 'type' => 'string'), '');
      echo form::get(array('id' => 'database_name', 'name' => rb::get('setup.database_name'), 'validator' => 'data-fv-notempty', 'type' => 'string'), '');
      echo form::get(array('id' => 'database_user', 'name' => rb::get('setup.database_user'), 'validator' => 'data-fv-notempty', 'type' => 'string'), '');
      echo form::get(array('id' => 'database_pwd', 'name' => rb::get('setup.database_pwd'), 'validator' => 'data-fv-notempty', 'type' => 'string'), '');
      echo '<p>'.rb::get('setup.steam').'</p>';
      echo form::get(array('id' => 'steam_apikey', 'name' => rb::get('setup.steam_apikey'), 'validator' => 'data-fv-notempty', 'type' => 'string'), '');
      modal::end(rb::get('setup.name'), 'success');
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>