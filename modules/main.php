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
		error('loginError.html');
		loadModule('login');
	}
?>
