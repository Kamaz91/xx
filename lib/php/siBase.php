<?php
$_SQL = array();
 ////  Definicje baz danych  V

$_SQL[0] = array(
  'db' => array(),
  'charset'=>'UTF8',
  'type' => 'mysql',
  'host' => 'localhost',
  'user' => 'esim',
  'password' => 'superpass',
  'database' => 'mydb',
  'prefix' => '',
);

 ////  Definicje baz danych  A

function sql_connect($n = 0)
{
  global $_MAIN, $_SQL;
  try
  {
    if(!isset($_MAIN['db']))
      $_MAIN['db'] = array();
    $_MAIN['db'][$n] = array();
    $_MAIN['db'][$n]['link'] = new PDO($_SQL[$n]['type'].':host='.$_SQL[$n]['host'].';dbname='.$_SQL[$n]['database'], $_SQL[$n]['user'], $_SQL[$n]['password']);
    $_MAIN['db'][$n]['link']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //$_MAIN['db'][$n]['link']->query('SET NAMES '.isset($_SQL[$n]['charset'])?$_SQL[$n]['charset']:'UTF8');
    $_MAIN['db'][$n]['connect'] = true;
  }
  catch(PDOException $e)
  {
    echo 'Połączenie z bazą danych `'.$n.'` jest teraz nie możliwe.';
    exit;
  }
}
function sql($sql, $table = false, $inputs = array(), $retrow = false, $n = 0)
{
  global $_MAIN, $_SQL;
  if($sql[0] == ':')
  {
    $word = explode(' ', $sql);
    if($word[0] == ':GET')
    {
      if($word[1] == '_SQL')
      return $_SQL[$n][$word[2]];
    }
  }
  if(!isset($_MAIN['db'][$n]['connect']))
  {
    sql_connect($n);
  }
  if(!is_array($inputs) && $inputs == true)
  {
    $inputs = array();
    $retrow = true;
  }
  if(is_array($table))
  {
    foreach($table as $k => $w)
    {
      $j = $k+1;
      $inputs['_table'.$j] = $w[0] == '_' ? substr($w, 1) : $_SQL[$n]['prefix'].$w ;
    }
  }
  else
  $inputs['_table'] = $table[0] == '_' ? substr($table, 1) : $_SQL[$n]['prefix'].$table ;
  foreach($inputs as $name => $value)
  {
    if($name[0] == '_')
    {
      unset($inputs[$name]);
      $name = substr($name, 1);
      $sql = str_replace(':'.$name.' ', '`'.$value.'` ', $sql);
      $sql = str_replace(':'.$name.'.', '`'.$value.'`.', $sql);
    }
    elseif($name[0] == '-')
    {
      unset($inputs[$name]);
      $name = substr($name, 1);
      $sql = str_replace(':'.$name, $value, $sql);
    }
  }

  $query = $_MAIN['db'][$n]['link']->prepare($sql);
  $types = array(
    'id' => 'int',
  );
  foreach($inputs as $name => $value)
  {
    if(strpos($sql, ':'.$name) !== false)
    {
      $type = (isset($types[$name]))?$types[$name]:'str';
      switch($type)
      {
        case 'int':
          $query->bindValue(':'.$name, $value, PDO::PARAM_INT);
         break;

        default:
        case 'str':
          $query->bindValue(':'.$name, $value, PDO::PARAM_STR);
         break;
      }
    }
  }
  $type = explode(' ', $sql);
  $type0 = strtoupper($type[0]);
  $type1 = strtoupper($type[1]);
  switch($type0)
  {
    case 'SELECT':
      $query->execute();
      $count = substr($type1, 0, 5) == 'COUNT' ? true:false;
      $group = strpos($sql, ' GROUP BY ') === false ? false:true;
      $retrow_last = $retrow;
      if($count && !$group) $retrow = true;
      if($retrow)
      {
        return removeslash($query->fetch(PDO::FETCH_ASSOC));
      }
      else
      {
        return removeslash($query->fetchAll(PDO::FETCH_ASSOC));
      }
      return $ret;
     break;

    case 'INSERT':
      if($retrow === false) return $query->execute();
      $query->execute();
      return $_MAIN['db'][$n]['link']->lastInsertId($retrow===true?'id':$retrow);
     break;


    default:
    case 'DELETE':
    case 'UPDATE':
      return $query->execute();
     break;
  }
  return false;
}
function removeslash($a)
{
  if(is_array($a))
  {
    foreach($a as $b => $c)
    {
      $a[$b] = removeslash($c);
    }
    return $a;
  }
  else
  {
    return stripslashes($a);
  }
}
?>
