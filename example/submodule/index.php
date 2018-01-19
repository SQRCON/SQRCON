<?php
  require_once(dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
  
  page::start();
  sidebar::start('example');
  
  table::toolbar(array('<button class="btn btn-success" data-toggle="modal" href="'.$dialog.'?action=modal" data-target="#modal"> <i class="fa fa-plus"></i> Test Button</button>'));
  
  $fields = array(
              array('id' => 'ID',
                    'name' => 'ID',
                    'width' => '50px'),
              array('id' => 'VALUE1',
                    'name' => 'Value1',
                    'sort' => true),
              array('id' => 'VALUE2',
                    'name' => 'Value2'),
              array('id' => 'VALUE3',
                    'name' => 'Value3',
                    'width' => '50px'),
              array('id' => 'VALUE4',
                    'name' => 'Value4',
                    'width' => '160px',
                    'align' => 'right'),
              array('id' => 'ID',
                    'name' => '',
                    'format' => 'rowaction',
                    'width' => '80px',
                    'align' => 'right')
            );
  
  table::construct($controller.'?action=init', $fields);
  
  sidebar::end();
  page::end();

?>