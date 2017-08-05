<?php

class db
{
  public static $jdb = '.jdb';
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
    $this->handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->handle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }
  
  public function construct()
  {
    foreach (module::read() as $key => $module) {
      if (file_exists($module->path.DIRECTORY_SEPARATOR.$module->id.db::$jdb)) {
        $this->handle($module);
      }
    }
  }
  
  public function query($query, $data = null)
  {
    $stmt = $this->handle->prepare($query);
    $stmt->execute($data);
    return $stmt;
  }
  
  public function read($table, $fields = '*', $conditions = null, $options = array())
  {
    $query = 'SELECT '.$fields.' FROM `'.TABLE_PREFIX.$table.'`';
    if ($conditions != null) {
      $query .= ' WHERE '.$conditions;
    }
    
    if (sizeof($options) > 0) {
      if (isset($options['group_by'])) {
        $query .= " GROUP BY ".$options['group_by'];
      }

      if (isset($options['order_by'])) {
        $query .= " ORDER BY ".$options['order_by'];
        if (isset($options['order_dir'])) {
          $query .= " ".strtoupper($options['order_dir']);
        }
      }

      if (isset($options['limit_start']) && isset($options['limit'])) {
        $query .= " LIMIT ".$options['limit_start'].", ".$options['limit'];
      } elseif (isset($options['limit'])) {
        $query .= " LIMIT ".$options['limit'];
      }
    }
    
    return $this->query($query);
  }
  
  public function write($table, $data, $conditions = null)
  {
    if ($conditions != null) {
      if ($this->query('SELECT * FROM `'.TABLE_PREFIX.$table.'` WHERE '.$conditions)->rowCount > 0) {
        $fields = '';
        foreach ($data as $key => $value) {
          $fields .= $key.'=?,';
        }
      
        $query = 'UPDATE `'.TABLE_PREFIX.$table.'` SET '.rtrim($fields, ',');
        if ($conditions != null) {
          $query .= ' WHERE '.$conditions;
        }
        return $this->query($query, array_values($data));
      } else {
        $fields = '';
        $keys = array();
        foreach ($data as $key => $value) {
          $fields .= '?,';
          array_push($keys, '`'.$key.'`');
        }
        
        $query = 'INSERT INTO `'.TABLE_PREFIX.$table.'` ('.implode(',', $keys).') VALUES ('.rtrim($fields, ',').')';
        return $this->query($query, array_values($data));
      }
    } else {
      $fields = '';
      $keys = array();
      foreach ($data as $key => $value) {
        $fields .= '?,';
        array_push($keys, '`'.$key.'`');
      }
      
      $query = 'INSERT INTO `'.TABLE_PREFIX.$table.'` ('.implode(',', $keys).') VALUES ('.rtrim($fields, ',').')';
      return $this->query($query, array_values($data));
    }
  }

  public function delete($table, $conditions = null)
  {
    if ($conditions != null) {
      return $this->query('DELETE FROM `'.TABLE_PREFIX.$table.'` WHERE '.$conditions);
    } else {
      return $this->query('DELETE FROM `'.TABLE_PREFIX.$table.'`');
    }
  }
  
  public function handle($module)
  {
    if (!$this->exists('schema')) {
      $this->query('CREATE TABLE `'.TABLE_PREFIX.'schema` ( `ID` INT NOT NULL AUTO_INCREMENT , `NAME` VARCHAR(255) NOT NULL , `VERSION` INT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = MyISAM');
    }
    
    $array = json_decode(file_get_contents($module->path.DIRECTORY_SEPARATOR.$module->id.db::$jdb), true);
    if (!$this->exists($module->id)) {
      $stmt = $this->write('schema', array('NAME' => $module->id, 'VERSION' => $array['version']));
      if (isset($array['schema'])) {
        $columns = array();
        $primarykey = '';
        $indexes = '';
        foreach ($array['schema'] as $item) {
          array_push($columns, '`'.strtoupper($item['name']).'` '.strtoupper($item['type']));
          if (isset($item['primary']) && $item['primary'] == true) {
            $primarykey = ', PRIMARY KEY (`'.strtoupper($item['name']).'`)';
          }
          if (isset($item['index']) && $item['index'] == true) {
            $indexes .= ', UNIQUE `'.strtoupper($item['name']).'` (`'.strtoupper($item['name']).'`)';
          }
        }
        $stmt = $this->query('CREATE TABLE `'.TABLE_PREFIX.$module->id.'` ('.implode(',', $columns).$primarykey.$indexes.') ENGINE = '.$array['engine']);
      }
    } else {
      if (isset($array['type']) && isset($array['version'])) {
        $stmt = $this->read('schema', 'version', 'name = '.$this->quote($module->id));
        if ($stmt->rowCount() == 1) {
          $result = $stmt->fetchAll()[0];
          if ($result['version'] < $array['version']) {
            foreach (explode(' ', $array['type']) as $type) {
              switch ($type) {
              case 'create':
                $stmt = $this->query('DROP TABLE `'.TABLE_PREFIX.$module->id.'`');
                $stmt = $this->query('DELETE FROM `'.TABLE_PREFIX.'schema` WHERE ID = '.$this->quote($module->id));
                $stmt = $this->write('schema', array('NAME' => $module->id, 'VERSION' => $array['version']));
                if (isset($array['schema'])) {
                  $columns = array();
                  $primarykey = '';
                  foreach ($array['schema'] as $item) {
                    array_push($columns, '`'.strtoupper($item['name']).'` '.strtoupper($item['type']));
                    if (isset($item['primary']) && $item['primary'] == true) {
                      $primarykey = ', PRIMARY KEY (`'.strtoupper($item['name']).'`)';
                    }
                    if (isset($item['index']) && $item['index'] == true) {
                      $indexes .= ', UNIQUE `'.strtoupper($item['name']).'` (`'.strtoupper($item['name']).'`)';
                    }
                  }
                  $stmt = $this->query('CREATE TABLE `'.TABLE_PREFIX.$module->id.'` ('.implode(',', $columns).$primarykey.$indexes.') ENGINE = '.$array['engine']);
                }
                break;
              case 'alter':
                $fields = array();
                foreach ($this->query('desc `'.TABLE_PREFIX.$module->id.'`')->fetchAll() as $item) {
                  array_push($fields, strtoupper($item['Field']));
                }

                if (isset($array['schema'])) {
                  foreach ($array['schema'] as $item) {
                    if (!in_array(strtoupper($item['name']), $fields)) {
                      $stmt = $this->handle->exec('ALTER TABLE `'.TABLE_PREFIX.$module->id.'` ADD `'.strtoupper($item['name']).'` '.strtoupper($item['type']).';');
                    } else {
                      unset($fields[array_search(strtoupper($item['name']), $fields)]);
                    }
                  }
                }
                $stmt = $this->query('UPDATE `'.TABLE_PREFIX.'schema` SET VERSION = '.$array['version'].' WHERE NAME = '.$this->quote($module->id));
                break;
              case 'clear':
                $stmt = $this->query('TRUNCATE `'.TABLE_PREFIX.$module->id.'`');
                break;
              case 'drop':
                $stmt = $this->query('DROP TABLE `'.TABLE_PREFIX.$module->id.'`');
                $stmt = $this->query('DELETE FROM `'.TABLE_PREFIX.'schema` WHERE ID = '.$this->quote($module->id));
                break;
              default:
                break;
            }
            }
          }
        }
      }
    }
  }
  
  public function quote($text)
  {
    return $this->handle->quote($text);
  }
  
  private function exists($name)
  {
    $result = false;
    try {
        $result = $this->query('SELECT 1 FROM '.TABLE_PREFIX.$name);
    } catch (Exception $e) {
        return $result;
    }
    return $result;
  }
}

?>