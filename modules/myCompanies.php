<?php
	global $_SETTINGS;

	$companies = sql('SELECT `id`,`name`,`type`,`level` FROM :table WHERE `owner` = :id','company',array(
		'id' => $_SESSION['ID']
	));
	if($companies){
		$html = '';
		foreach($companies as $c){
			$html .= loadTemplate('templates/companyRow',$c,true);
		}
	}
	else{
		$html = 'You have no companies';
	}
	$types = '';
	foreach($_SETTINGS['companyTypes'] as $comp){
		$types .= "<option value=$comp>$comp</option>";
	}
	loadTemplate('templates/myCompanies',array(
			'companies' => 'You have no companies',
			'types' => $types
		));
?>
