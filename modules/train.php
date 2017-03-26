<?php
  $data = sql('SELECT `str`,`train`,`xp` FROM :table WHERE `id` = :id','users',array('id'=>$_SESSION['ID']));
  if($data){
    $str = $data[0]['str'];
    if($data[0]['train'] == 0 && isset($_POST['train'])){
      $maxstr = sql('SELECT `str` FROM :table ORDER BY `str` DESC LIMIT 1','users')[0]['str'];
      $ratio = $maxstr / $str;
      $xp = $data[0]['xp'] + 5;
      $str += calculateStr($ratio, 50);
      $up = sql('UPDATE :table SET `str` = :str, `train` = :tr, `xp` = :xp WHERE `id` = :id','users',array(
        'id' => $_SESSION['ID'],
        'str' => $str,
        'tr' => 1,
        'xp' => $xp
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
