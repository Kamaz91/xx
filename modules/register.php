<?php
  if(isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['pass'])){
    print 'reg';
  }
  elseif(isset($_POST['nick']) || isset($_POST['email']) || isset($_POST['pass'])){
    print 'Error: data not complete';
  }
  else{
    include('modulesHTML/register.html');
  }
?>
