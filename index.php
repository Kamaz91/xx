<?php
  ini_set('display_errors', 1);
  include('engine.php');

  include('css/loadCSS.html');
  print '<script src="lib/js/siTools.js"></script>';

  listModules();
  loadSettings();

  include('modulesHTML/menu.html');
  print '<div class="container">';
  loadModule('stats');
    print '<div class="matrioshka">';
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
    print '</div>';
  include('modulesHTML/footer.html');
  print '</div>';
?>
