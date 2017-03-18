<?php
  if(isset($_POST['login'])){
    $query = sql('SELECT `id` FROM :table WHERE `nick` = :nick AND `pass` = :pass','users',array(
      'nick' => $_POST['login'],
      'pass' => hash('sha256', $_POST['pass'])
    ));
    if($query){
      $_SESSION['ID'] = $query[0]['id'];
      loadModule('main');
    }
    else{
      print 'wrong password or login';
    }
  }
  else{
    include('modulesHTML/login.html');
  }
?>
