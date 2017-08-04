<?php

require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');

if (network::get('action') != '') {
  switch (network::get('action')) {
    case 'navright_userprofil':
      echo '<div class="user-img-box pull-right dropdown">';
      echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
      echo '<img id="profile-img" class="user-img" src="'.user::selfread('avatar').'" />';
      echo '</a>';
      echo '<ul class="dropdown-menu" aria-labelledby="usermenu">';
      echo '<li class="user-name"><a href="'.user::selfread('profileurl').'" target="_blank"><span class="fa navbar-fa fa-steam" aria-hidden="true"></span> '.rb::get('core.steam_profile', array(user::selfread('personaname'))).'</a></li>';
      echo '<li role="separator" class="divider"></li>';
      
      if (strlen($_SERVER['QUERY_STRING']) == 0) {
        $_SERVER['REQUEST_URI'] .= '?logout';
      } else {
        $_SERVER['REQUEST_URI'] .= '&logout';
      }
      echo '<li><a href="'.$_SERVER['REQUEST_URI'].'"><span class="fa navbar-fa fa-sign-out" aria-hidden="true"></span> '.rb::get('core.logout').'</a></li>';
      echo '</ul>';
      echo '</div>';
      break;
    case 'navright_guest':
      if (strlen($_SERVER['QUERY_STRING']) == 0) {
        $_SERVER['REQUEST_URI'] .= '?login';
      } else {
        $_SERVER['REQUEST_URI'] .= '&login';
      }
      echo '<a href="'.$_SERVER['REQUEST_URI'].'" type="_self"><button type="button" class="btn btn-success" style="margin-top: 7px; margin-right: 5px">'.rb::get('core.login', array('<span class="fa navbar-fa fa-steam-square" aria-hidden="true"></span>')).'</button></a>';

      break;
    case 'debug':
      foreach ($_SESSION as $key => $value) {
        echo $key.'='.$value.'<br>';
      }
      break;
    default:
      network::error('invalid action - '.network::get('action'));
      break;
  }
}

?>