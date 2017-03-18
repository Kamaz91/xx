<?php
  set_include_path(__DIR__);

  include('lib/php/siBase.php');

  session_start();

  $_MODULES = array();
  $_SETTINGS = array();

  function loadModule($name){
    global $_MODULES;
    if(in_array($name, $_MODULES)){
      include('modules/'.strtolower($name).'.php');
    }
    else{
      include('modulesHTML/error.html');
    }
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
  function loadSettings(){
    global $_SETTINGS;
    $query - sql('SELECT `name`, `value` FROM :table', 'settings');
    if($query){
      foreach($query as $q){
        $_SETTINGS[$q['name']] = $q['value'];
      }
    }
    else{
      die('Error: Couldn\'t load settings');
    }
  }
?>
