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


      print '<div class="company">';
        loadTemplate('templates/companyInfo',array(
          'owner' => $owner[0]['nick'],
          'name' => $query[0]['name'],
          'type' => $query[0]['type'],
          'level' => $query[0]['level']
        ));
        print '<div class="workers">';
          if($workers){
            print '<table>';
              loadTemplate('templates/companyWorkers',array(
                'nick' => 'Nick',
                'pay' => 'Pay'
              ));
              foreach($workers as $w){
                loadTemplate('templates/companyWorkers',array(
                  'nick' => $w['nick'],
                  'pay' => 'TODO'
                ));
              }
            print '</table>';
          }
          else{
            print 'There are no workers';
          }
        print '</div>';
      print '</div>';

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
