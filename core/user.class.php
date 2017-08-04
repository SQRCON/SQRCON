<?php
  
class user
{
  private $id = null;
  private $data = array();

  public function __construct($id)
  {
    $this->id = $id;
    foreach (steam::getuser($id) as $key => $value) {
      $this->data[$key] =  $value;
    }
    if (sizeof($this->data) > 0) {
      foreach (steam::getbans($id) as $key => $value) {
        $this->data[strtolower($key)] =  $value;
      }
      $this->data['playtime'] = steam::getplaytime($id);
    }
  }
  
  public function read($index = null)
  {
    if ($index == null) {
      return $this->data;
    } else {
      if (isset($this->data[$index])) {
        return $this->data[$index];
      } else {
        return null;
      }
    }
  }

  public static function selfconstruct($id)
  {
    session::write('self.id', $id);
    foreach (steam::getuser($id) as $key => $value) {
      session::write('self.'.$key, $value);
    }
    foreach (steam::getbans($id) as $key => $value) {
      session::write('self.'.strtolower($key), $value);
    }
    session::write('self.playtime', steam::getplaytime($id));
  }
  
  public static function selfid()
  {
    if (session::read('self.id') != null) {
      return session::read('self.id');
    } else {
      return null;
    }
  }

  public static function isauthenicated()
  {
    return ((session::read('self.id') != null) ? true : false);
  }
  
  public static function selfread($key)
  {
    if (session::read('self.'.$key) != null) {
      return session::read('self.'.$key);
    } else {
      return null;
    }
  }
  
  public static function selfdestroy()
  {
    session::delete('self.id');
  }
}
  
?>