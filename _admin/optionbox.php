<?php

// Diese Funktion ermittelt die unique Einträge der Objektnamen und verwandelt
// sie in in eine <option> Liste innerhalb eines <select> Formelements
//
function dropbox($table, $field, $act_entry, $last)
{

//echo "act_entry = " . $act_entry . "<br>";

//Konfiguration includen
include "../_cd/config.php";

// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Datensätze Gruppe
$array_field = array();
$sql = "SELECT DISTINCT " . $field . " FROM " . $table . " order by '" . $field . "'";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Anzahl der Datensätze
$number = mysqli_num_rows($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


//echo "<br>SQL: " . $sql;
//echo "<br>Number: " . $number . "<br>";

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

    $current_field = $$field;
    array_push($array_field, $current_field);

    }


// Datenbank dichtmachen
//mysql_close();    

// Ersten Eintrag einfügen
//array_unshift($array_field,$last); 

// Wieviele unique Einträge ??
$number_entries = count($array_field);

// Ersten Eintrag "Alle" in die Liste einfügen
//$dropbox .= "<option value='all'>Alle</option>";

for($listbox=0;$listbox<$number_entries;$listbox++)
  {
  $dropbox .= "<option";
  
  if($act_entry == $array_field[$listbox])
    {
    $dropbox .= " selected";
    }

  $dropbox .= " value='" . $array_field[$listbox] . "'";
  
  $dropbox .= ">" . $array_field[$listbox] . "</option>";
  }

// Letzten Eintrag in die Liste einfügen
if($last != "")
  {
  $dropbox .= "<option value='" . $last . "'>" . $last . "</option>";
  }

//$dropbox = "<option>individuell ...</option>" . $dropbox;
$dropbox = "<option>Nicht gew&auml;hlt</option>" . $dropbox;
return $dropbox;
}

// ###########################################################


// $table = abgefragte Tabelle (remote)
// $field = abgefragtes Feld (remote)
// $act_entry = derzeitiger INHALT des lokalen Feldes
// $parentfield = NAME des lokalen Feldes, in das eingefügt wird
function chxbox($table, $field, $act_entry, $parentfield)
{
//echo "<textarea>act_entry:\n" . $act_entry . "</textarea>";
//echo "<textarea>arr_act_entry:\n" . explode('|',$act_entry)[0] . "</textarea>";
//echo "act_entry = " . $act_entry . "<br>";

//Konfiguration includen
include "../_cd/config.php";

// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Datensätze Gruppe
$array_field = array();
$sql = "SELECT DISTINCT " . $field . " FROM " . $table . " order by '" . $field . "'";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Anzahl der Datensätze
$number = mysqli_num_rows($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<br>SQL: " . $sql;
//echo "<br>Number: " . $number . "<br>";

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

    $current_field = $$field;
    array_push($array_field, $current_field);
    }

// Datenbank dichtmachen
mysqli_close($GLOBALS["___mysqli_ston"]);

// Wieviele unique Einträge ??
$number_entries = count($array_field);

// Derzeitiger Inhalt zu array
$arr_act_entry = explode("|", $act_entry);

//echo "<br>count: " . count($arr_act_entry) . "<br>";
//echo "<textarea>var_dump:";
//var_dump($arr_act_entry);
//echo "</textarea>";

for($listbox=0;$listbox<$number_entries;$listbox++)
  {
  $dropbox .= "<div class='admin_chk_long'>";

  //$dropbox .= " value='" . $array_field[$listbox] . "'";

  $dropbox .= "<input type='checkbox' name='" . $parentfield . "[]' value='" . $array_field[$listbox] . "'";

  // if in array $arr_act_entry then CHECK
  if (in_array($array_field[$listbox], $arr_act_entry))
  {
  $dropbox .= " checked";
  }

  // Ausgabe formatieren
  $tag_formattet = str_replace("_", " ", $array_field[$listbox]);

  $dropbox .= "> " . ucwords($tag_formattet);
  $dropbox .= "</div>";
  }

return $dropbox;
}
?>

