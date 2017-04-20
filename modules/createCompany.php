<?php
	global $_SETTINGS;
	if(in_array($_POST['type'],$_SETTINGS['companyTypes'])){
		$company = sql('INSERT INTO :table (`name`,`type`,`owner`) VALUES (:name,:type,:owner)','company',array(
			'name' => $_POST['name'],
			'type' => $_POST['type'],
			'owner' => $_SESSION['ID']
		),1);
		$tableName = $company.'_workers';
		$companyTable = sql('CREATE TABLE :table (`usrid` int(11) NOT NULL, `salary` double NOT NULL, `currency` text COLLATE utf8_bin NOT NULL)',$tableName);
		$key = sql('ALTER TABLE :table ADD PRIMARY KEY (`usrid`)',$tableName);
		if($companyTable && $key){
			print 'done';
		}
		else{
			error();
		}
	}
	else{
		error();
	}
?>
