<?php

class panel
{
  public static function start($title = '', $type = 'default')
  {
    echo '<div class="panel panel-'.$type.'">';
    echo '<div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div>';
    echo '<div class="panel-body">';
  }
          
  public static function end()
  {
    echo '</div>';
    echo '</div>';
  }
  
  public static function dashboard($dashboard = 'core')
  {
    $fieldset = array();
    foreach (scandir(BASE) as $item) {
      if (is_dir(BASE.DIRECTORY_SEPARATOR.$item) && $item != '.') {
        if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.'config.json')) {
          $tmp = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.'config.json'));
          if (isset($tmp->widget)) {
            foreach ($tmp->widget as $widget) {
              if ($widget->dashboard == $dashboard) {
                $target = BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$widget->target;              
                $parts = explode(' ', $widget->grid);
                if (sizeof($parts) == 5) {
                  if (array_key_exists($parts[0], $fieldset)) {
                    if ($parts[3] == 'left') {
                      while (isset($fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[1]][$parts[4]])) {
                        $parts[4] += 1;
                      };
                      $fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[1]][$parts[4]] = $target;
                    } elseif ($parts[3] == 'right') {
                      while (isset($fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[2]][$parts[4]])) {
                        $parts[4] += 1;
                      };
                      $fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[2]][$parts[4]] = $target;
                    }
                  } else {
                    if ($parts[1] == '12' && $parts[2] == '0') {
                      $fieldset[$parts[0]] = array($parts[3].'-col-sm-'.$parts[1] => array($parts[4] => $target));
                    } else {
                      if ($parts[3] == 'left') {
                        $fieldset[$parts[0]] = array('left-col-sm-'.$parts[1] => array($parts[4] => $target), 'right-col-sm-'.$parts[2] => array());
                      } elseif ($parts[3] == 'right') {
                        $fieldset[$parts[0]] = array('left-col-sm-'.$parts[1] => array(), 'right-col-sm-'.$parts[2] => array($parts[4] => $target));
                      }
                    }
                  }
                }
              }
            }
          }
        }
        foreach (scandir(BASE.DIRECTORY_SEPARATOR.$item) as $subitem) {
          if (is_dir(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem) && $subitem != '.' && $item != 'core') {
            if (file_exists(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.'config.json')) {
              $tmp = json_decode(file_get_contents(BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.'config.json'));
              if (isset($tmp->widget)) {
                foreach ($tmp->widget as $widget) {
                  if ($widget->dashboard == $dashboard) {
                    $target = BASE.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$subitem.DIRECTORY_SEPARATOR.$widget->target;              
                    $parts = explode(' ', $widget->grid);
                    if (sizeof($parts) == 5) {
                      if (array_key_exists($parts[0], $fieldset)) {
                        if ($parts[3] == 'left') {
                          while (isset($fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[1]][$parts[4]])) {
                            $parts[4] += 1;
                          };
                          $fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[1]][$parts[4]] = $target;
                        } elseif ($parts[3] == 'right') {
                          while (isset($fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[2]][$parts[4]])) {
                            $parts[4] += 1;
                          };
                          $fieldset[$parts[0]][$parts[3].'-col-sm-'.$parts[2]][$parts[4]] = $target;
                        }
                      } else {
                        if ($parts[1] == '12' && $parts[2] == '0') {
                          $fieldset[$parts[0]] = array($parts[3].'-col-sm-'.$parts[1] => array($parts[4] => $target));
                        } else {
                          if ($parts[3] == 'left') {
                            $fieldset[$parts[0]] = array('left-col-sm-'.$parts[1] => array($parts[4] => $target), 'right-col-sm-'.$parts[2] => array());
                          } elseif ($parts[3] == 'right') {
                            $fieldset[$parts[0]] = array('left-col-sm-'.$parts[1] => array(), 'right-col-sm-'.$parts[2] => array($parts[4] => $target));
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        } 
      }
    }
    
    ksort($fieldset);

    foreach ($fieldset as $key => $row) {
      echo '<div class="row">';
      foreach ($row as $key => $column) {
        echo '<div class="'.str_replace(array('left-', 'right-'), array('',''), $key).'">';
        ksort($column);
        foreach ($column as $key => $panel) {
          $offset = strpos($panel, '?');
          if ($offset !== false) {
            $params = substr($panel, $offset+1);
            $include = substr($panel, 0, $offset);
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
            include($panel);
          }
        }
        echo '</div>';
      }
      echo '</div>';
    }
  }
}

?>