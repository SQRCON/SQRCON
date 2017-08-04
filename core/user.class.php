<?php
  
class user
{
  public static function loggedin()
  {
    return ((session::read(static::class.'.id') != null) ? true : false);
  }

  public static function construct($id)
  {
    session::write(static::class.'.id', $id);
    foreach(steam::getuser($id) as $key => $value) {
      session::write(static::class.'.'.$key, $value);
    }
  }
  
  public static function id()
  {
    if (session::read(static::class.'.id') != null) {
      return session::read(static::class.'.id');
    } else {
      return null;
    }
  }
  
  public static function get($key)
  {
    if (session::read(static::class.'.'.$key) != null) {
      return session::read(static::class.'.'.$key);
    } else {
      return null;
    }
  }
  
  public static function deconstruct()
  {
    session::delete(static::class.'.id');
  }
}
  
?>