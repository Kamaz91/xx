<?php
  $data = sql('SELECT `str`,`train` FROM :table WHERE `id` = :id','users',array('id'=>$_SESSION['ID']));
  if($data){
    $str = $data[0]['str'];
    if($data[0]['train'] == 0 && isset($_POST['train'])){
      $maxstr = sql('SELECT `str` FROM :table ORDER BY `str` DESC LIMIT 1','users')[0]['str'];
      $ratio = $maxstr / $str;
      $base = calculateStr($ratio, 50);
      $str += $base;
      $up = sql('UPDATE :table SET `str` = :str, `train` = :tr WHERE `id` = :id','users',array(
        'id' => $_SESSION['ID'],
        'str' => $str,
        'tr' => 1
      ));
      if($up){
        loadHTML('templates/trained',array(
          'str' => $str,
          'message' => 'You have trained'
        ));
      }
      else{
        error();
      }
    }
    elseif($data[0]['train'] == 0){
      loadHTML('templates/trainForm',array(
        'str' => $str
      ));
    }
    else{
      loadHTML('templates/trained',array(
        'str' => $str,
        'message' => 'You have already trained today'
      ));//TODO: Make the template look properly
    }
  }
  else{
    error();
  }
?>
