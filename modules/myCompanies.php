<?php
	$companies = sql('SELECT `id`,`name`,`type`,`level` FROM :table WHERE `owner` = :id','company',array(
		'id' => $_SESSION['ID']
	));
	if($companies){
		global $_SETTINGS;

		$html = '';
		foreach($companies as $c){
			$html .= loadTemplate('templates/companyRow',$c,true);
		}
		$types = '';
		foreach($_SETTINGS['companyTypes'] as $comp){
			$types .= "<option value=$comp>$comp</option>";
		}
		loadTemplate('templates/myCompanies',array(
			'companies' => $html,
			'types' => $types
		));
	}
	else{
		loadTemplate('templates/myCompanies',array(
			'companies' => 'You have no companies'
		));
	}
?>
