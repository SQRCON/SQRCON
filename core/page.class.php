<?php

class page
{
  public static $time;
  public static $devices = 'hidden-xs hidden-sm display-md display-lg';

  public static function start($infobox = '', $onload = null)
  {
    self::$time = microtime(true);
    echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    echo '<html xmlns="http://www.w3.org/1999/xhtml">';
    echo '<meta charset="utf-8">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<head>';

    echo '<title>'.rb::get('core.name').'</title>';
    
    echo '<link rel="icon" type="image/x-icon" href="'.HOME.'/favicon.ico" />';
    echo '<meta name="robots" content="noindex">';
    
    $jsinclude = array(CORE.DIRECTORY_SEPARATOR.'js', CORE);
    foreach ($jsinclude as $path) {
      foreach (scandir($path) as $include) {
        if (is_file($path.DIRECTORY_SEPARATOR.$include) && strpos($include, '..') == 0 && strpos($include, 'min') == 0  && strtoupper(pathinfo($include, PATHINFO_EXTENSION)) == 'JS') {
          $ref = str_replace(DIRECTORY_SEPARATOR, URL_SEPARATOR, str_replace(BASE.DIRECTORY_SEPARATOR, '', $path)).URL_SEPARATOR.$include;
          echo '<script type="text/javascript" src="'.HOME.URL_SEPARATOR.$ref.(DEBUG ? '' : '?v='.time()).'"></script>';
        }
      }
    }
  
    $cssinclude = array(CORE.DIRECTORY_SEPARATOR.'css', CORE);
    foreach ($cssinclude as $path) {
      foreach (scandir($path) as $include) {
        if (is_file($path.DIRECTORY_SEPARATOR.$include) && strpos($include, '..') == 0 && strpos($include, 'min') == 0  && strtoupper(pathinfo($include, PATHINFO_EXTENSION)) == 'CSS') {
          $ref = str_replace(DIRECTORY_SEPARATOR, URL_SEPARATOR, str_replace(BASE.DIRECTORY_SEPARATOR, '', $path)).URL_SEPARATOR.$include;
          echo '<link type="text/css" href="'.HOME.URL_SEPARATOR.$ref.(DEBUG ? '' : '?v='.time()).'" rel="stylesheet" media="screen" />';
        }
      }
    }
        
    echo '</head>';
    echo '<body '.(isset($onload)?'onload="'.$onload.'"':'').'>';
    
    echo '<div class="navbar navbar-inverse navbar-fixed-top display-xs display-sm display-md display-lg" role="navigation">';
    echo '<div class="navbar-header">';
    echo '<a class="navbar-brand" href="'.HOME.'"><img style="max-width:30px; margin-top: -7px;" src="'.HOME.'/core/img/brand/favicon-32x32.png"> '.rb::get('core.name').'</a>';
    echo '</div>';
    // START RIGHT
    echo '<div class="navbar-right '.self::$devices.'">';
    echo '<ul class="nav navbar-nav">';
    // RENDER RIGHT

    echo '</ul>';
    if (user::authenicated()) {
      echo '<div class="user-img-box pull-right dropdown">';
      echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
      echo '<img id="profile-img" class="user-img" src="'.user::get('avatar').'" />';
      echo '</a>';
      echo '<ul class="dropdown-menu" aria-labelledby="usermenu">';
      echo '<li class="user-name"><a href="'.user::get('profileurl').'" target="_blank"><span class="fa navbar-fa fa-steam" aria-hidden="true"></span> '.rb::get('core.steam_profile', array(user::get('personaname'))).'</a></li>';
      echo '<li role="separator" class="divider"></li>';
      
      if (strlen($_SERVER['QUERY_STRING']) == 0) {
        $_SERVER['REQUEST_URI'] .= '?logout';
      } else {
        $_SERVER['REQUEST_URI'] .= '&logout';
      }
      echo '<li><a href="'.$_SERVER['REQUEST_URI'].'"><span class="fa navbar-fa fa-sign-out" aria-hidden="true"></span> '.rb::get('core.logout').'</a></li>';
      echo '</ul>';
      echo '</div>';
    } else {
      if (strlen($_SERVER['QUERY_STRING']) == 0) {
        $_SERVER['REQUEST_URI'] .= '?login';
      } else {
        $_SERVER['REQUEST_URI'] .= '&login';
      }
      echo '<a href="'.$_SERVER['REQUEST_URI'].'" type="_self"><button type="button" class="btn btn-success" style="margin-top: 7px; margin-right: 5px">'.rb::get('core.login', array('<span class="fa navbar-fa fa-steam-square" aria-hidden="true"></span>')).'</button></a>';
    }
    echo '</div>';
    // END RIGHT
    // START LEFT
    echo '<div class="navbar-left '.self::$devices.'" stlye="display: none!important;">';
    echo '<ul class="nav navbar-nav">';
    // RENDER LEFT

    echo '<li><div style="width:10px"></div></li>';
    echo '</ul>';
    echo '</div>';
    // END LEFT
    echo '</div>';
    echo '<div class="modal" id="modal" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-content" id="modal-content"><br>&nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i> '.rb::get('core.loading').'<br><br></div></div></div>';
    echo '<div class="container-fluid '.self::$devices.'">';
    echo '<div id="infobox" class="infobox">'.$infobox.'</div>';
  }
          
  public static function end()
  {
    echo '</div>';
    echo '<div class="container-fluid display-xs display-sm hidden-md hidden-lg">';
    echo '<div class="display-xs hidden-sm hidden-md hidden-lg not-supported">';
    echo '<div class="alert alert-danger"><b>'.rb::get('core.mobile_not_supported').'</div>';
    echo '</div>';
    echo '<div class="hidden-xs display-sm hidden-md hidden-lg not-supported">';
    echo '<div class="alert alert-danger"><b>'.rb::get('core.tablets_not_supported').'</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="footer navbar-fixed-bottom">';
    echo '<div class="container-fluid">';
    echo '<p class="text-muted"> <i id="loading" class="fa fa-spinner fa-spin hidden"></i> '.rb::get('core.footer', array(date('Y', time()), number_format(microtime(true) - self::$time, 5))).' <span id="async"></span></p>';
    echo '</div>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
  }
}

?>