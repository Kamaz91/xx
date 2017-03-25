<?php
  if(isset($_SESSION['ID'])){
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
    error('loginError.html');
    loadModule('login');
  }
?>
