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
        print '<div class="ownerInfo">';
          print $owner[0]['nick'];
        print '</div>';
        print '<div class="companyInfo">';
          print $query[0]['name'].'<br>';
          print $query[0]['type'].' '.$query[0]['level'];;
        print '</div>';
        print '<div class="workers">';
          if($workers){
            print '<table>';
              print '<tr>';
              print '<td>';
                print 'Nick';
              print '</td>';
              print '<td>';
                print 'Mony';
              print '</td>';
              print '</tr>';
              foreach($workers as $w){
                print '<tr>';
                print '<td>';
                  print $w['nick'];
                print '</td>';
                print '<td>';
                  print 'TODO';
                print '</td>';
                print '</tr>';
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
