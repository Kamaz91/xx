<?php
	global $_SETTINGS;

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$query = sql('SELECT * FROM :table WHERE `id` = :id','company',array(
			'id' => $_GET['id']
		));
		if($query){
			$owner = sql('SELECT `nick` FROM :table WHERE `ID` = :id','users',array(
				'id' => $query[0]['owner']
			));
			$workers = sql('SELECT `id`,`nick` FROM :table WHERE `company` = :company','users',array(
				'company' => $_GET['id']
			));
			$infoHTML = loadTemplate('templates/companyInfo',array(
				'owner' => $owner[0]['nick'],
				'name' => $query[0]['name'],
				'type' => $query[0]['type'],
				'level' => $query[0]['level']
			),1);
			$workersHTML = '';
			if($workers){
				foreach($workers as $w){
					$pay = sql('SELECT `salary`,`currency` FROM :table WHERE `usrid` = :id',$_GET['id'].'_workers',array(
						'id' => $w['id']
					));
					$workersHTML .= loadTemplate('templates/companyWorkers',array(
					'nick' => $w['nick'],
					'pay' => $pay[0]['salary'].' '.$pay[0]['currency']
					),1);
				}
			}
			else{
				$workersHTML = 'There are no workers';
			}
			loadTemplate('templates/company',array(
				'companyInfo' => $infoHTML,
				'workers' => $workersHTML
			));
			if($_SESSION['ID'] === $query[0]['owner']){
				$currencies = '';
				foreach($_SETTINGS['currencyTypes'] as $c){
					$currencies .= "<option value='$c'>$c</option>";
				}
				loadTemplate('templates/companyManagement',array(
					'id' => $_GET['id'],
					'currencies' => $currencies
				));
			}
		}
		else{
			error();
		}
	}
	else{
		error();
	}
?>
