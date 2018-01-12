<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'navleft':
      $module = module::selfread();
      echo '<ul class="nav navbar-nav">';
      if (isset($module->id) && $module->id == 'example') {
        echo '<li class="active">';
      } else {
        echo '<li>';
      }
      echo '<a href="'.CONTEXT.URL_SEPARATOR.'example'.URL_SEPARATOR.'"><i class="fa fa-film fa-fw"></i> '.rb::get('example.name').'</a>';
      echo '</li>';
      echo '</ul>';
      break;
    default:
      network::error(rb::get('core.invalid_action', array(network::get('action'))));
      break;
  }
}

?>