<style type="text/css">
<!--
.livesearch-form {
  float: right;
  margin: 10px 50px 0 0; }

.livesearch_result {
  list-style: none;
  margin: 0 0 0 -100;
  z-index: 2000;
  position: absolute;
  display: block;
  border: 1px solid #8E72B1;
  padding: 0; }

.livesearch_result LI {
  background: #fff;
  padding: 2px 5px; }

.livesearch_result LI:hover, .livesearch_result LI A:hover {
  text-decoration: none;
  background: #f5f5f5; }

.livesearch_hide {
  border: 2px solid red; }
-->
</style>

<?php
error_reporting(E_ALL);
include_once ("_functions.php");
//$xmlDoc=new DOMDocument();
//$xmlDoc->load("links.xml");

//$x=$xmlDoc->getElementsByTagName('link');

$q = $_GET["q"];
$q = ConvertUmlauts($q);

//echo "###" . $q . "###";
//echo "<dt>&uuml;" . $q . "</dt>";
$min_stringlength = 3;

/*
//get the q parameter from URL


//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('title');
    $z=$x->item($i)->getElementsByTagName('url');
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "' target='_blank'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<br /><a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "' target='_blank'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}
*/

//lookup all links from the xml file if length of q>0
if (strlen($q)>= $min_stringlength) {
  $hint="";

// Datenbank öffnen
include_once "../_cd/config.php";
$table_used = "dictionary";

//echo "strlen: " . strlen($q);
//echo "still here ..";
//echo "<br>SELECT * FROM $table_used WHERE trl_variable like '%$q%' AND aktiv=1 ORDER BY trl_variable ASC";
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"])) or die(mysqli_error($GLOBALS["___mysqli_ston"]));




// Query
$sql="SELECT * FROM $table_used WHERE trl_variable like '%$q%' ORDER BY trl_variable ASC";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "<br>" . $query;
// Wieviele Einträge ?
$number = mysqli_num_rows($result);
//echo "<br>number: " . $number;
// Wenn keine Einträge:
if($number == 0)
  {
  print "Keine Eintr&auml;ge";
  }
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

      $hint .= "<li><a href='adm_change.php?item=" . $id . "'>" . $trl_variable . "</a></li>";
      }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if(isset($hint))
  {
if ($hint=="") {
  //$response="no suggestion";
} else {
  $response = "<ul class='livesearch_result'>" . $hint . "</ul>";
}

//output the response
echo $response;
  }


?>