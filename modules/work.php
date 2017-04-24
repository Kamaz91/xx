<?php
	global $_SETTINGS;
	$company = sql('SELECT `name`,`owner`,`type`,`level` FROM :table WHERE `ID` = :id','company',array(
		'id' => $_SESSION['company']
	))[0];
	if(isset($_POST['work']) && $_SESSION['work'] != 1){
		$salary = sql('SELECT `salary`,`currency` FROM :table WHERE `usrid` = :id',$_SESSION['company'].'_workers',array(
			'id' => $_SESSION['ID']
		))[0];
		if($company && $salary){
			$money = sql('SELECT * FROM :table WHERE `usrid` = :id','currency',array(
				'id' => $company['owner']
			))[0][$salary['currency']];
			$money -= $salary['salary'];
			if($money >= 0){
				if(in_array($company['type'],$_SETTINGS['companyTypes']['raw'])){
					$type = 'raw';
				}
				else{
					$type = 'produce';
				}
				$production = calculateProduction($company['level'],$_SESSION['eco']);
				if($type === 'raw'){
					$update = sql('UPDATE :table SET `'.$company['type'].'` = `'.$company['type'].'` + :produce WHERE `usrid` = :id','items',array(
						'id' => $company['owner'],
						'produce' => $production
					));
				}
				elseif($type === 'produce'){
					$production = round($production);
					// VV items in companyTypes raw and produce are in the same order
					// VV which means that we can look for the raw material by getting the array key using the company type
					$key = $_SETTINGS['companyTypes']['raw'][array_search($company['type'],$_SETTINGS['companyTypes']['produce'])];
					$raw = sql('SELECT `'.$key.'` FROM :table WHERE `usrid` = :id','items',array(
						'id' => $company['owner']
					))[0][$key];
					if($raw - $production > 0){
						$product = round($production/$company['level']);
						$update = sql('UPDATE :table SET `'.$company['type'].'q'.$company['level'].'` = `'.$company['type'].'q'.$company['level'].'` + :product, `'.$key.'` = `'.$key.'` - :raw WHERE `usrid` = :id','items',array(
							'id' => $company['owner'],
							'product' => $product,
							'raw' => $production
						));
					}
					else{
						error('Your employer doesn\'t have enough raw materials');
						$update = FALSE;
					}
				}
				else{
					error();
				}
				if($update){
					pay($company['owner'],$_SESSION['ID'],$salary['salary'],$salary['currency']);
					updateUserData(array(
						'eco' => $_SESSION['eco'] + calculateEco($_SESSION['eco'],1),
						'xp' => $_SESSION['xp'] + 5,
						'work' => 1
					));
					loadTemplate('templates/worked',array(
						'name' => $company['name'],
						'type' => ucfirst($company['type']),
						'level' => 'level '.$company['level'],
						'message' => 'You have worked today'
					));
				}
			}
			else{
				error('Your employer doesn\'t have enough money');
			}
		}
		else{
			error();
		}
	}
	else{
		if($_SESSION['company'] != NULL && $_SESSION['work'] != 1){
			loadTemplate('templates/work',array(
				'name' => $company['name'],
				'type' => ucfirst($company['type']),
				'level' => 'level '.$company['level']
			));
		}
		elseif($_SESSION['company'] != NULL && $_SESSION['work'] == 1){
			loadTemplate('templates/worked',array(
				'name' => $company['name'],
				'type' => ucfirst($company['type']),
				'level' => 'level '.$company['level'],
				'message' => 'You have already worked today'
			));
		}
		else{
			error('You don\'t have a job');
		}
	}
?>
