<?php
$json_filename = $_GET[filename];

include "../_cd/config.php";
$sql = "Select * from stammdaten";

// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database);


if ($result = mysqli_query($GLOBALS["___mysqli_ston"], $sql))
  {
  $rows = array();
  while($r = mysqli_fetch_assoc($result)) {
      $rows[] = $r;
  }

  // JSON string ausgeben
  //print json_encode($rows);

  $json_data = json_encode($rows);


  // JSON schreiben
  $json_filename = "../" . $json_filename;
  $jsonfile = fopen($json_filename, "w");
  fwrite($jsonfile, $json_data);
  fclose($jsonfile);

  header("Location: admin.php?jok=yes");
  }
else
  {
  header("Location: admin.php?jok=no");
  }


?>




