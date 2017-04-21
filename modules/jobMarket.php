<?php
	$offers = sql('SELECT * FROM :table LIMIT 10','jobOffers');
	if($offers){
		$html = '';
		foreach($offers as $f){
			$company = sql('SELECT `name` FROM :table WHERE `id` = :id','company',array(
				'id' => $f['company']
			))[0];
			$html .= loadTemplate('templates/jobOffer',array(
				'company' => $company['name'],
				'salary' => $f['salary'],
				'currency' => $f['currency'],
				'skill' => $f['skill'],
				'id' => $f['ID']
			),1);
		}
	}
	else{
		$html = 'There are no job offers available';
	}
	loadTemplate('templates/jobMarket',array(
		'offers' => $html
	));
?>
