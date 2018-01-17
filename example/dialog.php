<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'navleft':
      topbar::renderbit('example', rb::get('example.name'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'film'));
      break;
    case 'sidebar':
      sidebar::renderbit('example', rb::get('example.name'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'film', 'beta' => true));
      break;
    case 'sidemenu':
      sidebar::startmenu('test', rb::get('example.testmenu'));
      sidebar::rendermenubit('test1', rb::get('example.testbit1'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'ban'));
      sidebar::endmenu();
      break;
    case 'widget':
      panel::start('Example Widget', 'danger');
      echo '<p>This is an example.</p>';
      panel::end();
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>