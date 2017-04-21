<?php
	if(!empty($_GET['id'])){
		$offer = sql('SELECT * FROM :table WHERE `ID` = :id','jobOffers',array(
			'id' => $_GET['id']
		))[0];
		if($offer){
			if($_SESSION['eco'] >= $offer['skill']){
				$work = sql('INSERT INTO :table (`usrid`,`salary`,`currency`) VALUES (:id,:salary,:currency)',$offer['company'].'_workers',array(
					'id' =>	$_SESSION['ID'],
					'salary' =>	$offer['salary'],
					'currency' =>	$offer['currency']
				));
				$usr = sql('UPDATE :table SET `company` = :company WHERE `ID` = :id','users',array(
					'company' => $offer['company'],
					'id' => $_SESSION['ID']
				));
				if($work){
					$count = $offer['quantity'] - 1;
					if($count == 0){
						$delete = sql('DELETE FROM :table WHERE `ID` = :id','jobOffers',array(
							'id' => $_GET['id']
						));
						if($delete){
							print 'done';
						}
						else{
							error();
						}
					}
					else{
						$update = sql('UPDATE :table SET `quantity` = :q WHERE `ID` = :id','jobOffers',array(
							'q' => $count,
							'id' => $_GET['id']
						));
						if($update){
							print 'done';
						}
						else{
							error();
						}
					}
				}
				else{
					error();
				}
			}
			else{
				error('Your economy skill is lower than required');
			}
		}
		else{
			error('Offer is no longer available');
		}
	}
	else{
		error();
	}
?>
