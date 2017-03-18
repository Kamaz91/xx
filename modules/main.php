<?php
  if(isset($_SESSION['ID'])){
    print 'Welcome to Main';
  }
  else{
    include('modulesHTML/loginError.html');
    loadModule('login');
  }
?>
