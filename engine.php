<?php
  include('./lib/php/siBase.php');
  function loadModule($name){
    include('./modules/'.$name.'.php');
  }
?>
