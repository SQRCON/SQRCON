<?php

class db
{
  private static $instance = array();
  private $handle;
  
  public static function instance($index = 'default')
  {
      if (!isset(db::$instance[$index]) || !db::$instance[$index] instanceof self) {
        db::$instance[$index] = new self($index);
      }
      return db::$instance[$index];
  }
   
  public function __construct()
  {
    $this->handle = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME, DATABASE_USER, DATABASE_PWD);
  }
  
  public function query($query, $data = null)
  {
    $stmt = $this->handle->prepare($query);
    $stmt->execute($data);
    return $stmt; 
  }
  
  public function read($table, $fields = '*', $conditions = null, $options = array())
  {
    $query = 'SELECT '.$fields.' FROM '.TABLE_PREFIX.$table;
    if ($conditions != null) {
      $query .= ' WHERE '.$conditions;
    }
    
    if (sizeof($options) > 0) {
      if(isset($options['group_by'])) {
        $query .= " GROUP BY ".$options['group_by'];
      }

      if(isset($options['order_by'])) {
        $query .= " ORDER BY ".$options['order_by'];
        if(isset($options['order_dir'])) {
          $query .= " ".strtoupper($options['order_dir']);
        }
      }

      if(isset($options['limit_start']) && isset($options['limit'])) {
        $query .= " LIMIT ".$options['limit_start'].", ".$options['limit'];
      } else if(isset($options['limit'])) {
        $query .= " LIMIT ".$options['limit'];
      }
    }
      
    return $this->query($query);
  }
  
  public function write($table, $data, $conditions = null)
  {
    if ($conditions != null) {
      if ($this->query('SELECT * FROM '.$table.' WHERE '.$conditions)->rowCount > 0) {
        $fields = '';
        foreach($data as $key=>$value) {
          $fields .= $key.'=?,'; 
        }
      
        $query = 'UPDATE '.$table.' SET '.rtrim($fields,',');
        if($conditions != null) {
          $query .= ' WHERE '.$conditions;
        }
        
        $stmt = $this->handle->prepare($query);
        $stmt->execute(array_values($data));
        return $stmt;
      } else {
        $fields = '';
        foreach($data as $key=>$value) {
          $fields .= '?,'; 
        }
        
        $query = 'INSERT INTO '.$table.' ('.implode(',', array_keys($data)).') VALUES ('.rtrim($fields,',').')';
        return $this->query($query, array_values($data));
      }
    } else {
      $fields = '';
      foreach($data as $key=>$value) {
        $fields .= '?,'; 
      }
      
      $query = 'INSERT INTO '.$table.' ('.implode(',', array_keys($data)).') VALUES ('.rtrim($fields,',').')';
      return $this->query($query, array_values($data));
    }
  }

  public function delete($table, $conditions = null)
  {
    if ($conditions != null) {
      return $this->query('DELETE FROM '.$table.' WHERE '.$conditions);
    } else {
      return $this->query('DELETE FROM '.$table);
    }
  }
}

?>