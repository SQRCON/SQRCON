<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
   
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
      
      define('TABLE_PREFIX', '');
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
      session::construct();
    }
    
    public static function load($path)
    {
      foreach (scandir($path) as $include) {
        if (is_file($path.DIRECTORY_SEPARATOR.$include) && strpos($path.DIRECTORY_SEPARATOR.$include, '.class.') !== false && strtoupper(pathinfo($include, PATHINFO_EXTENSION)) == 'PHP') {
          require_once($path.DIRECTORY_SEPARATOR.$include);
        }
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