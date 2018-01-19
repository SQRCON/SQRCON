<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'navleft':
      topbar::bit('example', rb::get('example.name'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'server', 'badge' => 2));
      break;
    case 'sidebar':
      sidebar::bit('example', rb::get('example.name'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'youtube', 'beta' => true));
      break;
    case 'sidemenu':
      sidebar::menustart('test', rb::get('example.testmenu'), array('icon' => 'gear', 'lock' => true, 'badge' => 100, 'beta' => true, 'disabled' => true));
      sidebar::menuheader(rb::get('example.header'));
      sidebar::menubit('test1', rb::get('example.testbit1'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'users', 'lock' => true));
      sidebar::menudivider();
      sidebar::menubit('test2', rb::get('example.testbit1'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'wifi', 'beta' => true));
      sidebar::menubit('test3', rb::get('example.testbit1'), CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR, array('icon' => 'signal', 'disabled' => true));
      sidebar::menuend();
      break;
    case 'config':
      $output = 'Example Administration Page<br>This is an example.';
      network::success($output);
      break;
    case 'config2':
      $output = 'Example Administration Page #2';
      network::success($output);
      break;
    case 'widget':
      dashboard::widgetstart('Example Widget', 'danger');
      echo '<p>This is an example.</p>';
      dashboard::widgetend();
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>