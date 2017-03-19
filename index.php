<?php
  ini_set('display_errors', 1);
  include('engine.php');

  include('css/loadCSS.html');

  listModules();
  loadSettings();

  print '<div class="container">';
  include('modulesHTML/menu.html');
  if(maintenanceCheck() == false){
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
  }

  include('modulesHTML/footer.html');
  print '</div>';
?>
