<?php
	if(isset($_SESSION['ID'])){
		loadTemplate('templates/main',array(
			'news' => loadNews(),
			'battles' => loadBattles($_SESSION['country']),
			'shout' => loadShout(),
			'quickInfo' => loadInfo()
		));
	}
	else{
		error('Error: You must be logged in to access this page');
		loadModule('login');
	}
?>
