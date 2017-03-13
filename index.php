<?php
  //ini_set('display_errors', 1);
  include('engine.php');
  if($_SESSION){

  }
  else{
    loadModule('login');
  }
?>
