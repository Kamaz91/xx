<?php
  if(isset($_SESSION['ID'])){
    loadTemplate('templates/main',array(
      'news' => loadNews(),
      'battles' => loadBattles(),
      'shout' => loadShout(),
      'quickInfo' => loadInfo()
    ));
    /*
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
    */
  }
  else{
    error('loginError.html');
    loadModule('login');
  }
?>
