<?php

// Diese Funktion ermittelt die unique Einträge der Objektnamen und verwandelt
// sie in in eine <option> Liste innerhalb eines <select> Formelements
//
function dropbox($table, $field1, $field2, $act_entry, $first)
{
//Konfiguration includen
include "../_cd/config.php";

// Datenbank öffnen
mysql_connect($host, $username, $password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());

// Datensätze Gruppe
$query = "SELECT DISTINCT " . $field1 . ", " . $field2 . " FROM " . $table . " order by '" . $field1 . "'";
$ergebnis = mysql_query( $query ) or die(mysql_error());
$anz_reihen = mysql_num_rows( $ergebnis );

$array_field = array();
$array_value = array();

// Alle Gruppen auslesen
while ( $datensatz = mysql_fetch_assoc( $ergebnis ) )
  {
  //print $datensatz["$field1"] . "<br>";
  array_push($array_field, $datensatz["$field1"] . " (" . $datensatz["$field2"] . ")");
  array_push($array_value, $datensatz["$field1"]);
  }

// Array sortieren
sort($array_field);
sort($array_value);

// Datenbank dichtmachen
//mysql_close();

// Ersten Eintrag einfügen
//array_unshift($array_field,$first); 

// Wieviele unique Einträge ??
$number_entries = count($array_field);

// Ersten Eintrag in die Liste einfügen
$dropbox = "<option value='none'>" . $first . "</option>";

// Ersten Eintrag "Alle" in die Liste einfügen
//$dropbox .= "<option value='all'>Alle</option>";

for($listbox=0;$listbox<$number_entries;$listbox++)
  {
  
  $dropbox .="<option";
  
  if($act_entry == $array_value[$listbox])
    {
    $dropbox .= " selected";
    }
  
  $dropbox .= " value='" . $array_value[$listbox] . "'";
  
  $dropbox .= ">" . $array_field[$listbox] . "</option>";
  }

return $dropbox;
}

?>