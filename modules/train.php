<?php
	//$data = sql('SELECT `str`,`train`,`xp` FROM :table WHERE `id` = :id','users',array('id'=>$_SESSION['ID']));
	if($_SESSION['train'] == 0 && isset($_POST['train'])){
		$maxstr = sql('SELECT `str` FROM :table ORDER BY `str` DESC LIMIT 1','users')[0]['str'];
		$ratio = $maxstr / $_SESSION['str'];
		$xp = $_SESSION['xp'] + 5;
		$str = $_SESSION['str'] + calculateStr($ratio, 50);
		$up = sql('UPDATE :table SET `str` = :str, `train` = :tr, `xp` = :xp WHERE `id` = :id','users',array(
			'id' => $_SESSION['ID'],
			'str' => $str,
			'tr' => 1,
			'xp' => $xp
		));
		if($up){
			$_SESSION['train'] = 1;
			$_SESSION['str'] = $str;
			$_SESSION['xp'] = $xp;
			loadTemplate('templates/trained',array(
				'str' => $str,
				'message' => 'You have trained'
			));
		}
		else{
			error();
		}
	}
	elseif($_SESSION['train'] == 0){
		loadTemplate('templates/trainForm',array(
			'str' => $_SESSION['str']
		));
	}
	else{
		loadTemplate('templates/trained',array(
			'str' => $_SESSION['str'],
			'message' => 'You have already trained today'
		));//TODO: Make the template look properly
	}
?>
