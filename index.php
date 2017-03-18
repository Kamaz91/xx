<?php
  ini_set('display_errors', 1);
  include('engine.php');

  listModules();

  if(isset($_GET['module'])){
    loadModule($_GET['module']);
  }
  else{
    if(isset($_SESSION['ID'])){
      loadModule('main');
    }
    else{
      loadModule('login');
    }
  }
?>
