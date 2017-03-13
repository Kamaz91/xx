<?php
  ini_set('display_errors', 1);
  include('engine.php');

  if($_GET['module'] == 'register'){
    loadModule('register');
  }
  else{
    if($_SESSION){
      loadModule('main');
    }
    else{
      loadModule('login');
    }
  }
?>
