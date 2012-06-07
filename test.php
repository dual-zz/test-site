<?php
session_start();
?>
<pre>
<?php
require './class/database/config.php';
$mass;
try
{
   $db = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
   //$db->prepare("SELECT id FROM session");
   $que = $db->query("SELECT * FROM user");
   echo $que->rowCount();
   
   SQL_Error($db);
   
   while ($row = $que->fetch())
   {
      print_r($row);
      if ($row['id'] == 50)
      {
          $mass = $row;
      }
      //print_r($row);
   }
}
catch (PDOException $ee)
{
   echo $ee->getMessage();
   echo "root problen";
}

print_r($mass);

$_SESSION['nya'] = $mass;
print_r($_SESSION['nya']);
echo $mass['login'] . $mass['pass'] . '/n' . $_SESSION['nya']['id'];



?>