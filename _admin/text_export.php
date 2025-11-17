<?php
error_reporting(E_ALL);
foreach (array_keys($_GET) as $key) $$key=$_GET[$key];
foreach (array_keys($_POST) as $key) $$key=$_POST[$key];

// Configuration
include ("../_cd/config.php");
include ("_functions.php");

//print "<meta NAME='author' CONTENT='Š2006 carpe diem! Werbeagentur - www.carpediem.at'>\n";
//print "<meta NAME='author' CONTENT='Alle Rechte vorbehalten'>\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
print "\n<html>";
print "\n<head>";
print "\n<meta http-equiv='content-type' content='text/html; charset=iso-8859-2'>";
print "\n<link rel='stylesheet' type='text/css' href='style_translate.css'>\n";

print "\n</head>";
print "\n\n<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0' marginwidth='0' marginheight='0'>";


// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// default-order: vorgegebene Reihenfolge
if($order == "")
{
$order = "con_seite";
}

$sql="select DISTINCT con_seite from content order by $order asc";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Wieviele Einträge ?
$number = mysqli_num_rows($result);

// Wenn keine Einträge:
if($number == 0)
  {
  echo "keine Einträge";
  }

// Ansonsten auflisten
else
  {
  // Pro Datensatz wird eine Tabellenzeile geschrieben
  for ($i = 0; $i < $number; $i++)
      {
      // Variable entsprechend den Feldnamen werden erstellt
      $fields = count(mysqli_fetch_row($result));
      //echo "Fields: " . $fields;
      for ($f = 0; $f < $fields; $f++)
        {
        $var = ((($___mysqli_tmp = mysqli_fetch_field_direct($result, $f)->name) && (!is_null($___mysqli_tmp))) ? $___mysqli_tmp : false);
        $$var = mysqli_result($result,  $i,  $var);
        }

        // do something
        echo "<br>" . $i;

      }
  }
?>


</body>
</html>




