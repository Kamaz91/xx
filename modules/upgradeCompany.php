<?php
	if(isset($_POST['id'])){
		$company = sql('SELECT `level`, `owner` FROM :table WHERE `ID` = :id','company',array(
			'id' => $_POST['id']
		))[0];
		if($company && $company['owner'] === $_SESSION['ID']){
			if($company['level'] < 5){
				$gold = sql('SELECT `gold` FROM :table WHERE `usrid` = :id','currency',array(
					'id' => $company['owner']
				))[0]['gold'];
				$gold -= 20;
				if($gold >= 0){
					$update = sql('UPDATE :table SET `level` = `level` + 1 WHERE `ID` = :id','company',array(
						'id' => $_POST['id'],
					));
					if($update){
						pay($company['owner'], 'server', 20, 'gold');
					}
					else{
						error();
					}
				}
				else{
					error('You don\'t have enough money to pay for the upgrade');
				}
			}
			else{
				error('You already have the max company level');
			}
		}
		else{
			error();
		}
	}
?>
