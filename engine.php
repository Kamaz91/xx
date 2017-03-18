<?php
  set_include_path(__DIR__);

  include('lib/php/siBase.php');

  session_start();

  $_MODULES = array();

  function loadModule($name){
    include('modules/'.$name.'.php');
  }
  function listModules(){
    global $_MODULES;

    $query = sql('SELECT `name` FROM :table WHERE `enabled` = :enabled', 'modules', array('enabled' => 1));
    if($query){
      foreach($query as $q){
        $_MODULES[] = $q['name'];
      }
    }
    else{
      die('Error: Couldn\'t load modules');
    }
  }
?>
