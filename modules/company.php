<?php
  if(isset($_GET['id']) && !empty($_GET['id'])){
    $query = sql('SELECT * FROM :table WHERE `id` = :id','company',array(
      'id' => $_GET['id']
    ));
    if($query){
      $owner = sql('SELECT `nick` FROM :table WHERE `ID` = :id','users',array(
        'id' => $query[0]['owner']
      ));
      $workers = sql('SELECT `nick` FROM :table WHERE `company` = :company','users',array(
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
        	$workersHTML .= loadTemplate('templates/companyWorkers',array(
        	'nick' => $w['nick'],
        	'pay' => 'TODO'
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
        print '<div class="manage">';
          print 'Manage me plez oh great master';
        print '</div>';
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
