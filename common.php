<?php
  if (file_exists(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php')) {
    require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  }
   
  common::construct();
  class common
  {
    public static function construct()
    {
      set_exception_handler(array('common', 'errorhandler'));
      define('COOKIE_LIFETIME', 60*60*24*7*4*3);
      
      define('BASE', dirname(realpath(__FILE__)));
      define('CORE', BASE.DIRECTORY_SEPARATOR.'core');
      define('CACHE', BASE.DIRECTORY_SEPARATOR.'cache');
      
      define('STEAM_APPID', 393380);
      
      define('TABLE_PREFIX', 'sqrcon_');
      define('URL_SEPARATOR', '/');
      
      if (isset($_SERVER['REQUEST_URI'])) {
        $urlparts = explode(URL_SEPARATOR, $_SERVER['REQUEST_URI']);
        $baseparts = explode(DIRECTORY_SEPARATOR, str_replace($_SERVER['DOCUMENT_ROOT'], '', BASE));
        
        $tmp = '';
        foreach ($urlparts as $key => $value) {
          if (in_array($value, $baseparts)) {
            $tmp .= URL_SEPARATOR.$value;
          }
        }
        
        define('HOME', $tmp);
      } else {
        define('HOME', null);
      }
      define('DEBUG', false);
      
      common::load(CORE.DIRECTORY_SEPARATOR.'inc');
      common::load(CORE);
      $module = module::selfread();
      if ($module != null) {
        common::load($module->path);
      }
      
      session::construct();
      db::instance()->construct();
    }
    
    public static function load($path)
    {
      foreach (scandir($path) as $include) {
        if (is_file($path.DIRECTORY_SEPARATOR.$include) && strpos($path.DIRECTORY_SEPARATOR.$include, '.class.') !== false && strtoupper(pathinfo($include, PATHINFO_EXTENSION)) == 'PHP') {
          require_once($path.DIRECTORY_SEPARATOR.$include);
        }
      }
    }
    
    public static function run($target)
    {
      $offset = strpos($target, '?');
      if ($offset !== false) {
        $params = substr($target, $offset+1);
        $include = substr($target, 0, $offset);
        foreach (explode('&', $params) as $value) {
          $parts = explode('=', $value);
          if (sizeof($parts) == 2) {
            $_GET[$parts[0]] = $parts[1];
          } else {
            $_GET[$parts[0]] = '';
          }
        }
        include($include);
      } else {
        include($target);
      }
    }
    
    public static function errorhandler($ex)
    {
      echo '<h1>Error detected - '.$ex->getCode().'</h1>';
      echo '<b>Exception:</b> '.$ex->getMessage().'<br>';
      echo '<b>Trace:</b> ';
      echo $ex->getFile().' on line '.$ex->getLine().'<br>';
      foreach ($ex->getTrace() as $key => $value) {
        echo '- '.$value['file'].' on line '.$value['line'].'<br>';
      }
      echo '<br><hr><br><b>SERVER:</b><br>';
      foreach ($_SERVER as $key => $value) {
        echo $key.'='.$value.'<br>';
      }
    }
  }
  
?>