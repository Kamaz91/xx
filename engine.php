<?php
  set_include_path(__DIR__);

  include('lib/php/siBase.php');

  session_start();

  $_MODULES = array();
  $_SETTINGS = array();

  function error($n = 'error.html'){
    include('modulesHTML/error/'.$n);
  }
  function loadModule($name){
    global $_MODULES;
    if(in_array($name, $_MODULES)){
      include('modules/'.$name.'.php');
    }
    else{
      error();
    }
  }
  function listModules(){
    global $_MODULES;
    if(!empty($_MODULES)){
      $_MODULES = array();
    }
    $query = sql('SELECT `name` FROM :table WHERE `enabled` = :enabled', 'modules', array('enabled' => 1));
    if($query){
      foreach($query as $q){
        $_MODULES[] = $q['name'];
      }
    }
    else{
      error();
    }
  }
  function loadSettings(){
    global $_SETTINGS;
    if(!empty($_SETTINGS)){
      $_SETTINGS = array();
    }
    $query = sql('SELECT `name`, `value` FROM :table WHERE 1', 'settings'); // WHERE 1...
    if($query){
      foreach($query as $q){
        $_SETTINGS[$q['name']] = $q['value'];
      }
    }
    else{
      error();
    }
  }
  function maintenanceCheck(){
    $query = sql('SELECT `value` FROM :table WHERE `name` = :name','settings',array(
      'name' => 'maintenance'
    ));
    if($query){
      if($query[0]['value'] == 1){
        error('maintenance.html');
        return true;
      }
      else{
        return false;
      }
    }
    else{
      error();
    }
  }
  function loadTemplate($file, $data = array(), $return = false){
    $fdata = file_get_contents('modulesHTML/'.$file.'.html', true);
    if(!empty($data)){
      foreach($data as $key => $value){
        $tag = "[@$key]";
        $fdata = str_replace($tag,$value,$fdata);
      }
      if($return == true){
        return $fdata;
      }
      else{
        echo $fdata;
      }
    }
    else{
      if($return == true){
        return $fdata;
      }
      else{
        echo $fdata;
      }
    }
  }
  function calculateStr($ratio = 1, $base = 50){
    if($ratio === 1){
      return $base;
    }
    elseif($ratio > 1 && $ratio < 2){
      return $base *= 2;
    }
    elseif($ratio >= 2 && $ratio < 3){
      return $base *= 3;
    }
    elseif($ratio >= 3){
      return $base *= 4;
    }
  }
  function loadShout(){
    $html = 'Shout';
    return $html;
  }
  function loadBattles(){
    $html = 'Battles';
    return $html;
  }
  function loadNews(){
    $html = 'News';
    return $html;
  }
  function loadInfo(){
    $html = 'Info';
    return $html;
  }
?>
