<?php
  if(isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['pass'])){
    if(strlen($_POST['nick']) < 3){
      include('modulesHTML/nickShort.html');
    }
    elseif(strlen($_POST['pass']) < 5){
      include('modulesHTML/passShort.html');
    }
    else{
      $register = sql('INSERT INTO :table (`nick`,`email`,`pass`) VALUES (:nick,:email,:pass)','users',array(
        'nick' => $_POST['nick'],
        'email' => $_POST['email'],
        'pass' => hash('sha256', $_POST['pass'])
      ));
      if($register){
        include('modulesHTML/regSuccess.html');
      }
      else{
        include('modulesHTML/unableToReg.html');
      }
    }
  }
  elseif(isset($_POST['nick']) || isset($_POST['email']) || isset($_POST['pass'])){
    include('modulesHTML/error.html');
  }
  else{
    include('modulesHTML/register.html');
  }
?>
