<?php
	ini_set('display_errors', 1);
	include('engine.php');

	include('css/loadCSS.html');
	include('lib/js/loadJS.html');

	listModules();
	loadSettings();

	if(!empty($_SESSION['ID'])){
		loadUserData($_SESSION['ID']);
	}

	include('modulesHTML/menu.html');
	print '<div class="container">';
	loadModule('stats');
		print '<div class="matrioshka">';
			if(maintenanceCheck() == false){
				if(!empty($_SESSION['ID'])){
					if(!empty($_GET['module'])){
						loadModule($_GET['module']);
					}
					else{
						loadModule('main');
					}
				}
				else{
					if($_GET['module'] === 'register'){
						loadModule('register');
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
