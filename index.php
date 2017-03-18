<?php
  ini_set('display_errors', 1);
  include('engine.php');

  include('css/loadCSS.html');

  listModules();
  loadSettings();

  include('modulesHTML/menu.html');
  print '<div class="container">';

  if(isset($_GET['module'])){
    loadModule($_GET['module']);
  }
  else{
    if(isset($_SESSION['ID'])){
      loadModule('main');
    }
    else{
      loadModule('login');
    }
  }
  print '</div>';
  include('modulesHTML/footer.html');
?>
