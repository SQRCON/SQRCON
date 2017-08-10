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
    foreach (steam::getuser($id) as $key => $value) {
      session::write('self.'.$key, $value);
    }
    if (session::read('self.steamid') != null) {
      foreach (steam::getbans($id) as $key => $value) {
        session::write('self.'.strtolower($key), $value);
      }
      session::write('self.playtime', steam::getplaytime($id));
      $permissions = array();
      foreach (module::read() as $key => $tmp) {
        if (isset($tmp->permissions)) {
          if (isset($tmp->permissions->default)) {
            foreach ($tmp->permissions->default as $key => $value) {
              foreach ($value as $subkey => $subvalue) {
                array_push($permissions, $key.'.'.$subvalue);
              }
            }
          }
        }
      }
      session::write('self.permissions', implode(",", $permissions));
    } else {
      throw new Exception(rb::get('core.invalid_steamapi_key'));
    }
  }
  
  public static function selfid()
  {
    if (session::read('self.steamid') != null) {
      return session::read('self.steamid');
    } else {
      return null;
    }
  }

  public static function isauthenicated()
  {
    return ((session::read('self.steamid') != null) ? true : false);
  }
  
  public static function haspermission($permission)
  {
    if (session::read('self.permissions') != null) {
      return (in_array($permission, explode(",", session::read('self.permissions'))) ? true : false);
    } else {
      return false;
    }
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
    session::delete('self.steamid');
  }
}
  
?>