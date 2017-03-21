<?php
  if(isset($_SESSION['ID'])){
    print '<div class="stats">';
      loadModule('stats');
    print '</div>';
    print '<div class="main">';
      print '<div class="news">';
        loadModule('newsList');
      print '</div>';
      print '<div class="battles">';
        loadModule('battleList');
      print '</div>';
      print '<div class="shout">';
        loadModule('shouts');
      print '</div>';
      print '<div class="quickInfo">';
        loadModule('infoList');
      print '</div>';
    print '</div>';
  }
  else{
    include('modulesHTML/loginError.html');
    loadModule('login');
  }
?>
