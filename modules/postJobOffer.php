<?php
	// id, salary, currency, skill, quantity
	if(!empty($_POST['id']) && !empty($_POST['salary']) && !empty($_POST['currency']) && !empty($_POST['skill']) && !empty($_POST['quantity'])){
		if($_POST['id'] != 0 && $_POST['salary'] >= 1 && $_POST['skill'] >= 1 && $_POST['quantity'] >= 1){
			$offer = sql('INSERT INTO :table (`company`,`salary`,`currency`,`skill`,`quantity`) VALUES (:company,:salary,:currency,:skill,:quantity)','jobOffers',array(
				'company' => $_POST['id'],
				'salary' => $_POST['salary'],
				'currency' => $_POST['currency'],
				'skill' => $_POST['skill'],
				'quantity' => $_POST['quantity']
			));
			if($offer){
				print 'done';
			}
			else{
				error();
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
