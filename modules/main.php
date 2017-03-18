<?php
  if(isset($_SESSION['ID'])){
    print '<div class="stats">';
    print '</div>';
    print '<div class="main">';
      print '<div class="news">';

      print '</div>';
      print '<div class="battles">';

      print '</div>';
      print '<div class="shout">';

      print '</div>';
      print '<div class="quickInfo">';

      print '</div>';
    print '</div>';
  }
  else{
    include('modulesHTML/loginError.html');
    loadModule('login');
  }
?>
