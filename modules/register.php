<?php
	if(isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['pass'])){
		if(strlen($_POST['nick']) < 3){
			error('Nickname is too short');
		}
		elseif(strlen($_POST['pass']) < 5){
			error('Password is too short');
		}
		else{
			global $_SETTINGS;
			$register = sql('INSERT INTO :table (`nick`,`email`,`pass`,`day`,`country`) VALUES (:nick,:email,:pass,:day,:country)','users',array(
				'nick' => $_POST['nick'],
				'email' => $_POST['email'],
				'pass' => hash('sha256', $_POST['pass']),
				'day' => $_SETTINGS['day'],
				'country' => $_POST['country']
			),true);
			$currency = sql('INSERT INTO :table (`usrid`) VALUES (:id)','currency',array(
				'id' => $register
			));
			$items = sql('INSERT INTO :table (`usrid`) VALUES (:id)','items',array(
				'id' => $register
			));
			if($register){
				include('modulesHTML/regSuccess.html');
			}
			else{
				error();
			}
		}
	}
	elseif(isset($_POST['nick']) || isset($_POST['email']) || isset($_POST['pass'])){
		error();
	}
	else{
		$query = sql('SELECT `id`, `name` FROM :table WHERE 1','country');
		if($query){
			$countries = '';
			foreach($query as $q){
				$countries .= loadTemplate('templates/countryOption',array(
					'id' => $q['id'],
					'name' => $q['name']
				),1);
			}
			loadTemplate('register',array(
				'countries' => $countries
			));
		}
		else{
		error();
		}
	}
?>
