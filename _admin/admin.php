<?php
session_start();
//error_reporting(0);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//echo "Adminchoice: " . $_GET['adminsection'] . "<br>";
//echo $_SESSION['this_adminarea'];

// Verfübare Admin-Ebenen
require ("plugin/_sections.php");

// Configuration
include_once ("../_cd/config.php");
include_once ("_functions.php");

// Reset flags
$exist_session = 0;
$exist_get = 0;

// String from Array
@$str_adminsections = implode($arr_adminsections);
@$needle_session = "|" . $_SESSION['this_adminarea'];
@$needle_get = "|" . $_GET['adminsection'];

?>
<script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
<?php



// Section als Session übergeben und existent?
if (strpos($str_adminsections, $needle_session) !== false AND strlen($needle_session) > 1)
  {
  $exist_session = 1;
  }

// Section als Get übergeben und existent?
if (strpos($str_adminsections, $needle_get) !== false AND strlen($needle_get) > 1)
  {
  $exist_get = 1;
  //sessionme("this_adminarea", $needle_get);
  }

//echo "<br>Session exists: " . $exist_session . " (" . $_SESSION['this_adminarea'] . ")<br>";
//echo "Get exists: " . $exist_get . " (" . $_GET['adminsection'] . ")<br>";


/*// Wenn eine neue Admin-Ebene gewählt wurde, inkl Reset von order auf id
  if ($_SESSION['this_adminarea'] == "" OR $_GET['adminsection'] != "")
    {
    sessionme("this_adminarea", $_GET['adminsection']);
    }*/

// Plugin laden
  if ($exist_get == 1)
    {
    $this_plugin = "_plugin_" . $_GET['adminsection'] . ".php";
    sessionme("this_adminarea", $_GET['adminsection']);
    }
  else if ($exist_session == 1)
    {
    $this_plugin = "_plugin_" . $_SESSION['this_adminarea'] . ".php";
    sessionme("this_adminarea", $_SESSION['this_adminarea']);
    }
  else
    {
    $this_plugin = "_plugin_" . $section_default . ".php";
    sessionme("this_adminarea", $section_default);
    }


//echo strtolower($this_plugin);

// Session-Reset

  sessionme("order", "");
  sessionme("sortdir", "");

  require "plugin/" . strtolower($this_plugin);

  //### 221206, bw, new code for new plugin format ###//
  $show_admin = array();
  $show_label = array();
  $show_type = array();

  $db_fields = array();
  $db_labels = array();
  $db_type = array();

  foreach ($arr_admin AS $this_admin)
    {
    $arr_parts = explode("|", $this_admin);
    //var_dump($arr_parts);

    $part_label = $arr_parts[0];
    $part_fieldname = $arr_parts[1];
    $part_fieldtype = $arr_parts[2];
    $part_showadmin = $arr_parts[3];

    array_push($db_labels, $part_label);
    array_push($db_fields, $part_fieldname);
    array_push($db_type, $part_fieldtype);

    if($part_showadmin == 1)
      {
      array_push($show_label, $part_label);
      array_push($show_admin, $part_fieldname);
      array_push($show_type, $part_fieldtype);
      }
    }
  //var_dump($show_admin);
  //var_dump($db_fields);
  $show_admin_count = count($show_admin);
  //### 221206, bw, new code for new plugin format eof ###//

  //echo "Table: " . $table_used . "<br>";
  //echo "This Plugin: " . $this_plugin . "<br>";
  //echo "ID-Proxy: " . $id_proxy . "<br>";


// DEBUGGING
//include "_admin_debug.php";


if($_SESSION['order'] == "" AND $_GET['order'] == "")
  {
  sessionme("order", $default_order);
  }

//echo "Start:<br>";
//echo "<br>Default-Sortdir: " . $default_sortdir;
//echo "<br>Get-Sortdir: " . $_GET['sortdir'];
//echo "<br>Session-Sortdir: " . $_SESSION['sortdir'] . "<br><br>";

if($_SESSION['sortdir'] == "" AND $_GET['sortdir'] == "")
  {
  sessionme("sortdir", $default_sortdir);
  }

if($_SESSION['adminarea'] == "")
  {
  sessionme("adminarea", $section_default);
  }

if($_SESSION['this_adminarea'] == "")
  {
  sessionme("this_adminarea", $section_default);
  }

if($_SESSION['adminsection'] == "")
  {
  sessionme("adminsection", $section_default);
  }


function sortfix($table_used, $sortfield, $id)
  {
  $query = "SELECT * FROM " . $table_used . " ORDER BY " . $sortfield . "";

  //echo "Sortfix 1st Query: " . $query . "<br>";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  // Anzahl der Datensätze
  $sort_number = mysqli_num_rows($result);
  //echo "Number: " . $sort_number . "<br>";

  if($sort_number > 0)
    {
    // Alle Datensätze durchlaufen
    for ($i = 0; $i < $sort_number; $i++)
      {
      // Variable entsprechend den Feldnamen werden erstellt
      $fields = count(mysqli_fetch_row($result));

      for ($f = 0; $f < $fields; $f++)
        {
        $var = ((($___mysqli_tmp = mysqli_fetch_field_direct($result, $f)->name) && (!is_null($___mysqli_tmp))) ? $___mysqli_tmp : false);
        $$var = mysqli_result($result,  $i,  $var);
        }
      // Pro Datensatz wird eine Zeile geschrieben
      $inner_query = "UPDATE " . $table_used . " SET " . $sortfield . " = '" . ($i +10) . "' WHERE id = " . $id;
      //echo "<br>Inner Query: " . $inner_query . "<br>";
      $inner_result = mysqli_query($GLOBALS["___mysqli_ston"], $inner_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      }
    }
  }




// Wenn order übergeben übernehmen, oder id verwenden
if($_GET['order'] == "")
  {
  sessionme("order", $default_order);
  }
else
  {
  sessionme("order", $_GET['order']);
  }


// Eintrag kopieren
  $item   = $_GET['item'];
  $copyme = $_GET['copyme'];
  if ($copyme == "yes" AND $item>0 AND $_SESSION['this_adminarea'] == "seitentexte")
    {
    //echo "Table: " . $table_used . "<br>";
    // Datenbank öffnen
    ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    $query = "SELECT * FROM " . $table_used . " WHERE " . $id_proxy . " = " . $item;
    //echo "<br><br>A: " . $query . "<br><br>";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $row = mysqli_fetch_assoc($result);
    extract($row);
    ((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);

    $query = "INSERT INTO $table_used (con_seite, con_seitentitel, con_bezeichner) VALUES ('" . $con_seite . "', '" . $con_seitentitel . "', 'lan_')";
    //echo "<br><br>B: " . $query . "<br><br>";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

    unset($copyme);
    unset($_GET['copyme']);
    }

//echo $table_used , " - " . $sortorder_proxy . " - " . $id_proxy;

?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">

<title>Administration</title>
<base target="_self">
<link rel='stylesheet' type='text/css' href='style.css'>

<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>

<body style="background:#f7f7f7;margin:0;padding:0;">

<?php
// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


// Sortfix nach Änderung
if($_GET['upd'] == 1 AND $sortorder_proxy != "")
  {
  sortfix($table_used, $sortorder_proxy, $id_proxy);
  }

// Sortiert die Einträge nach Benutzervorgabe
$sortup = $_GET['sortup'];
$sortdown = $_GET['sortdown'];

if($sortup != "")
  {
  $change_from = $sortup;
  $change_to   = $sortup-1;

  //echo "Change from: " . $change_from;
  //echo "<br>Change to: " . $change_to;

  $query = "update $table_used set $sortorder_proxy=999999 where $sortorder_proxy=$change_to";
  //echo $query . "<br>";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $query = "update $table_used set $sortorder_proxy=$change_to where $sortorder_proxy=$change_from";
  //echo $query . "<br>";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $query = "update $table_used set $sortorder_proxy=$change_from where $sortorder_proxy=999999";
  //echo $query . "<br>";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  sortfix($table_used, $sortorder_proxy, $id_proxy);
  }

if($sortdown != "")
  {
  $change_from = $sortdown;
  $change_to   = $sortdown+1;
  $query = "update $table_used set $sortorder_proxy=999999 where $sortorder_proxy=$change_to";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $query = "update $table_used set $sortorder_proxy=$change_to where $sortorder_proxy=$change_from";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $query = "update $table_used set $sortorder_proxy=$change_from where $sortorder_proxy=999999";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  sortfix($table_used, $sortorder_proxy, $id_proxy);
  }

function unixtime($ymd)
{
$jahr =  intval(substr($ymd,0,4));
$monat =  intval(substr($ymd,5,2));
$tag =  intval(substr($ymd,8,2));
return  mktime(0,0,0,$monat,$tag,$jahr);
}

// Wenn kein Sortier-Link gewählt, default-order
//echo "<br>Default-Order: " . $default_order;
//echo "<br>Get-Order: " . $_GET['order'];
//echo "<br>Session-Order: " . $_SESSION['order'];
//echo "<br><br>Default-Sortdir: " . $default_sortdir;
//echo "<br>Get-Sortdir: " . $_GET['sortdir'];
//echo "<br>Session-Sortdir: " . $_SESSION['sortdir'];


if($_SESSION['order'] == "")
  {
  $_SESSION['order'] = $default_order;
  }

//Sortstop
//sessionme("sortstop", 99);

// Schaltet aktiv oder inaktiv
$changeactive = $_GET['changeactive'];
//echo "Sid: " . $id_proxy . "<br>";
//echo "SSid: " . $$id_proxy . "<br>";
$change_id = $_GET[$id_proxy];
//echo "chid: " . $change_id . "<br>";
if ( $changeactive == "yes" )
{
$query = "update $table_used set aktiv=1 where $id_proxy = $change_id";
//echo $query;
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$changeactive = "";
$sortstop = 1;
}
if ( $changeactive == "no" )
{
$query = "update $table_used set aktiv=0 where $id_proxy = $change_id";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$changeactive = "";
$sortstop = 1;
}

// Schaltet zwischen Sortierungsreihenfolge um
if ($_SESSION['sortstop'] != 99)
  {

  if($_GET['sortdir'] != "")
    {
    sessionme("sortdir", $_GET['sortdir']);
    }
  }

// Je nach gewählter Sortierfolge wird der richtige Pfeil angezeigt
$arrow = $sortdir . "arrow.gif";

//echo "<br>Session-Order: " . $_SESSION['order'];
//echo "<br>Session-Sortdir: " . $_SESSION['sortdir'];
//echo "<br>Session-Sortstop: " . $_SESSION['sortstop'];

//echo "<br>Order: " . $_SESSION['order'] . "<br>";

$query = "SELECT * FROM $table_used ORDER BY " . $_SESSION['order'] . " " . $_SESSION['sortdir'];
//echo "<br>" . $query;

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<br>Result: " . print_r($result) . "<br>";
//echo "<br>Num-Rows: " . $result->num_rows . "<br>";

// Anzahl der Datensätze
if($result->num_rows < 1)
  {
  $number = 0;
  //echo "No entries";
  }
else
  {
  //echo "Result!<br>";
  $number = mysqli_num_rows($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  }

//echo "<br>querynumber is: " . $number;

//print $number . " Eintr&auml;ge gefunden<br><br>";


// Tabellenbeginn New Navi
?>
<table width='100%' style="margin-top:0;">
  <tr class='topmenu_toprow'>
    <td class='topmenu_spacer'>&nbsp;</td>
    <td class='headline'>

    <form id="adminchoice" method="GET" action="admin.php">
      <label>Auswahl:&nbsp;
        <select class="adminsection" name="adminsection" onchange="change()">
        <?php
        echo "Adminarea: " . $adminarea . "<br>";
        foreach ($arr_adminsections AS $this_section)
          {
          $arr_sectionparts = explode("|", $this_section);
          $this_sectionname = $arr_sectionparts[0];
          $this_sectioncode = $arr_sectionparts[1];

          echo '<option ';
          if(strtolower($this_sectioncode) == $_SESSION['this_adminarea'] OR strtolower($this_sectioncode) == $_GET['adminsection'])
            {
            echo 'selected id="topmenu_selected" ';
            }
          echo 'value="' . strtolower($this_sectioncode) . '">' . $this_sectionname . '</option>';
          }

        //echo '<option>Adminarea: ' . $_SESSION["adminarea"] . '</option>';
        ?>
        </select>
        <!--<input type="hidden" name="copyme" value="no">-->
      </label>
    </form>

    </td>
    <td class='topmenu_logo'><a href='http://www.carpediem.at' target='_blank' rel='noopener'><img src='images/adm_right.png' border='0'></a></td>
  </tr>
  <tr class='topmenu_bottomrow'>
    <td>&nbsp;</td>
    <td class='topmenu_newentry'>
    <?php if($block_newentry != "yes")
    { ?>
    <a href='adm_change.php?adminarea=<?php echo urlencode($_SESSION['this_adminarea']); ?>'><b>Neuer Eintrag</b></a>

    <?php
    }
    ?>
   </td>
    <td><a href="backup.php" target="_blank" rel="noopener" style="float:right;margin-right: 20px;"><b>DB-Backup</b></a>
<a href="manual/admin_docs.pdf" target="_blank" rel="noopener" style="float:right;margin-right: 20px;">Manual anzeigen (PDF)</a></td>
  </tr>
</table>
<br>

<?php

  print "<table width='98%' align='center' class='admin_begin'>";
  print "<tr>";
  print "<td align='center'><h2>Admin-Center <span class='adminsection'>" . ucfirst($_SESSION['this_adminarea']) . "</span></h2><br>";
  print "<h3>Hier k&ouml;nnen Sie " . $this_topic_p . " &auml;ndern oder neu anlegen</h3>";

if(isset($admin_info))
  {
  echo "<br><div class='admin_info'>" . $admin_info . "</div>";
  }

// Excel
  if($export_excel == 1)
    {
    print "<p><a href='excel.php?filename=" . urlencode($excel_filename) . "'>Liste als Excel erzeugen</a></p>";
    }

// JSON
/*  if($export_json == 1)
    {
    print "<br><button class='adminsection writedata' xstyle='background:#B8B8B8;font-size: 120%;font-weight:bold;padding:5px 20px;border:none;'><a href='json.php?filename=" . urlencode($json_filename) . "'>Stammdaten schreiben</a></button><br><br>";
    if ($_GET[jok] == "yes")
      {
      print "<p style='background:#00CC33'><b>JSON erfolgreich geschrieben</b></p>";
      }
    else if ($_GET['jok'] == "no")
      {
      print "<p style='background:#CC0000'><b>Fehler beim Schreiben von JSON</b></p>";
      }

    }*/

// JSON SCHREIBEN
  if($export_json == 1 AND $_GET['upd'] == 1)
    {
      if(isset($json_mode) AND $json_mode == "assoc")
        {
// Create connection
/*$conn = mysqli_connect("localhost", "root", "", "maerchen");*/

// Check connection
/*if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}*/

$jsql = "SELECT * FROM " . $json_table;
$jresult = mysqli_query($GLOBALS["___mysqli_ston"], $jsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//$jresult = mysqli_query($conn, $jsql);

$jrows = array();
while($r = mysqli_fetch_assoc($jresult)) {
  $jrows[$r["$json_idfield"]] = $r;
}

     // JSON schreiben
      $json_filename = $json_path . $json_filename;
      $jsonfile = fopen($json_filename, "w");
      fwrite($jsonfile, json_encode($jrows));
      fclose($jsonfile);

        }
      else
        {
//$locale = $_GET["lang"];
//echo "locale: " . $locale;
//$locale = "de";

//echo "<br>Adminsection is " . $_SESSION['this_adminarea'];

//$stsql = "SELECT con_seite, con_bezeichner, con_data_de FROM " . $json_table . " ORDER BY con_seite ASC";
  if(!isset($json_sortorder))
    {
    $json_sortorder = "id";
    }

  //echo "<br>" .  $stsql . "'<br>";

    // Datenbank öffnen
    ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "<script>alert('db selected');</script>";

// check if "aktiv" exists
if (mysqli_query($GLOBALS["___mysqli_ston"], "SELECT aktiv FROM $json_table")){
      $stsql = "SELECT * FROM " . $json_table . " WHERE aktiv=1 ORDER BY $json_sortorder ASC";
    }
else{
      $stsql = "SELECT * FROM " . $json_table . " ORDER BY $json_sortorder ASC";
}

$stresult = mysqli_query($GLOBALS["___mysqli_ston"], $stsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "<script>alert('queried');</script>";
//echo "<script>alert($stresult');</script>";
    if ($stresult = mysqli_query($GLOBALS["___mysqli_ston"], $stsql))
      {
      // Wieviele Einträge ?
      $number = mysqli_num_rows($result);
//echo "<script>alert('" . $number . "');</script>";
//echo "<br>querynumber is: " . $number;
      $strows = array();
      while($str = mysqli_fetch_assoc($stresult)) {
          $strows[] = $str;
      }

      // JSON string ausgeben
      //print json_encode($rows);

      $json_data = json_encode($strows);

      // Character conversions
      //$json_data = decode_special($json_data);

      // JSON schreiben
      $json_filename = $json_path . $json_filename;
      //echo "<br><br><br><br>" . $json_filename . "<br><br><br><br><br>";
      $jsonfile = fopen($json_filename, "w");

      // Sonderzeichen zurückholen
      $json_data = html_entity_decode($json_data);

      // \r entfernen
      $json_data = str_replace("\\r", "", $json_data);

      // \n entfernen
      $json_data = str_replace("\\n", "", $json_data);

      // \/ entfernen
      //$json_data = str_replace("\\/", "", $json_data);

//echo "<br><br>#" . $jsonfile . "#";
      fwrite($jsonfile, $json_data);
      fclose($jsonfile);
      //echo "hello<br>";
//echo "<script>alert('YES');</script>";
      }


else
  {
echo "<script>alert('did not work');</script>";
}
    }
    }
// Dictionary SCHREIBEN

function array_push_assoc($array, $key, $value){
   $array[$key] = $value;
   return $array;
}

  if($export_lang == 1 AND $_GET['upd'] == 1)
    {
    //echo "table: " . $table_used;
    //$locale = $_GET["lang"];

    // Datenbank öffnen
    ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    mysqli_select_db($GLOBALS["___mysqli_ston"], $database);

    // All locales to export
    foreach($export_locales AS $current_language)
      {
        //echo "\n#### trl_" . $current_language . " Filename: _" . $current_language . $lang_filename . "\n";
      $trl_field = "trl_" . $current_language;
      $stsql = "SELECT trl_variable, " . $trl_field . " FROM " . $table_used;
      //echo "<br>#" . $stsql . "#<br>";

      if ($stresult = mysqli_query($GLOBALS["___mysqli_ston"], $stsql))
        {

        $strows = array();

        while($str = mysqli_fetch_assoc($stresult)) {

            $strows[] = $str;
            //echo "trl_variable: -" . $trl_variable . "-, trl_field: " . $trl_field . "<br>";
        }
          //var_dump($strows);

$translation_output = array();

foreach($strows AS $this_row)
  {
  //var_dump($this_row) . "<br>";
  //echo $this_row['trl_variable'] . " should be " . $this_row[$trl_field] . "<br><br>";
  $var = $this_row['trl_variable'];
  $val = $this_row[$trl_field];
  $push = "$var=>$val";
  //array_push($translation_output,$push);

$translation_output = array_push_assoc($translation_output, $var, $val);

  //echo $var . " should be " . $val . "<br><br>";
  //var_dump($translation_output) . "<br>";
  }
//var_dump($translation_output) . "<br>";
  //echo $translation_output[0]['trl_kontakt'];

        // JSON string ausgeben
        //print json_encode($rows);

        $json_data = json_encode($translation_output);


        // JSON schreiben
        $json_filename = $json_path . "_" . $current_language . $lang_filename;
        $jsonfile = fopen($json_filename, "w");
        fwrite($jsonfile, decode_special($json_data));
        fclose($jsonfile);
        //echo "<br><br><br><br>" . $json_filename . "<br><br><br><br><br>";
        //end;
        }
      }

//echo "<br><br><br>" . $stsql . "<br><br><br>";
    }

  print "</td>";
//echo "<br><br><br>adminsection: " . $_SESSION['this_adminarea'];
if($_SESSION['this_adminarea'] == "dictionary")
  {
  print "<td width='20%'>";
  print '<form class="livesearch-form">
  <input type="text" id="livesearch_input" placeholder=" Livesearch" size="30" onkeyup="showResult(this.value)">
  <div id="livesearch"></div>
  </form>';
  print "</td>";
  }
  print "</tr>";
  print "</table>";

// Tabellenbeginn ausgeben
  print "<table width='98%' align='center' class='datatable'>";

  print "<tr class='tableheadtop tableheadadmin'>";
  print "<td nowrap class='tableheadtop tableheadadmin'>AKTION</td>";

function toggle_sortdir($current)
  {
  if($current == "asc")
    {
    return "desc";
    }
  else
    {
    return "asc";
    }
  }

  // Pro Eintrag eine Spalte
  for ($sa=0; $sa<$show_admin_count; $sa++)
    {
    print "<td nowrap>";
    print "<a href='" . $_SERVER['PHP_SELF'] . "?order=" . $show_admin[$sa] . "&sortdir=" . toggle_sortdir($_SESSION['sortdir']) . "' class='tableheadtop'>" . $show_label[$sa] . "</a>";
//echo "<br><br>shadmin: " . $show_admin[$sa] . "<br><br>";
    if ($order == $show_admin[$sa])
    {
    //print "<img src='images/" . $arrow . "' valign='absmiddle' border ='0' width='16' height='14'>";
    }
    print "</td>";
    }

  print "</tr>";
  //print "<tr>";
  //print "<td colspan='7'><img src='images/14by14.gif' width='10' height='5'></td>";
  //print "</tr>";

// Limits für Sortierung
$sort_min = 10;
$sort_max = $number+9;

//echo "<br>number is: " . $number;

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
  //echo "var: " . $$var . "<br>";
  }


  // Datum einfärben, je nach Status
  $heute = unixtime(date("Y-m-d"));
  if (unixtime($date_start) > $heute)
    {
    $indexclass = "idx_yellow";
    }
  else if (unixtime($date_start) <= $heute AND unixtime($date_end) >= $heute)
    {
    $indexclass = "idx_green";
    }
  else if (unixtime($date_end) < $heute)
    {
    $indexclass = "idx_red";
    }
  else
    {
    $indexclass = "";
    }

  // Datum wird umgewandelt
  $startdatum_conv = substr($date_start,8,2) . "." . substr($date_start,5,2) . "." . substr($date_start,0,4);
  $enddatum_conv = substr($date_end,8,2) . "." . substr($date_end,5,2) . "." . substr($date_end,0,4);

  $this_active_id = $$id_proxy;
  //echo "ID: " . $this_active_id . "<br>";

  if ($aktiv == "1")
  {
  $aktiv_conv = "<a href='" . $_SERVER['PHP_SELF'] . "?order=$order&sortdir=$sortdir&$id_proxy=$this_active_id&changeactive=no&upd=1' class='activestatus isactive'>JA</a>";
  }
  else
  {
  $aktiv_conv = "<a href='" . $_SERVER['PHP_SELF'] . "?order=$order&sortdir=$sortdir&$id_proxy=$this_active_id&changeactive=yes&upd=1' class='activestatus isinactive'>NEIN</a>";
  }

  $greyback = "#EfEfEf";


  print "<tr><td class='lcol'>";
  print "<a href='adm_change.php?item=" . $$id_proxy . "&adminarea=" . urlencode($_SESSION['this_adminarea']) . "'>";

  if($view_only != 1)
    {
    print "Eintrag&nbsp;&auml;ndern";
    }
  else
    {
    print "Eintrag&nbsp;ansehen";
    }

  print "</a>";
  print "</td>";

//echo "<br>admincount: " . $show_admin_count;

  // Pro Eintrag eine Spalte
  for ($sa=0; $sa<$show_admin_count; $sa++)
    {
    $this_type = $show_type[$sa];
    $current_entry = ${$show_admin[$sa]};

//echo "<br>This type: " . $this_type . ", this value: " . $current_entry;
//echo "<br>This current_entry: " . $current_entry;

//echo $$show_type[0];

if($this_type == "rad_aktiv")
  {
  print "<td class='whitelinks'>";
  print $aktiv_conv;
  print "</td>";
  }

elseif($this_type == "area" OR $this_type == "html")
  {
  print "<td>";
  print strip_tags(substr($current_entry, 0, 150)) . "...";
  print "</td>";
  }

elseif(substr($this_type,0,4) == "date")
  {
  if($current_entry < 1 )
    {$this_date = "-";}
  else
    {$this_date = strftime("%d.%m.%Y", $current_entry);}
  print "<td>";
  print "<span class='" . $xindexclass . "'>" . $this_date . "</span>";
  print "</td>";
  }

elseif($this_type == "string" OR $this_type == "text" OR substr($this_type,0,3) == "sel" OR $this_type == "view")
  {
  print "<td>";
  print $current_entry;
  print "</td>";
  }

elseif($this_type == "bool")
  {
  print "<td>";
  if($current_entry > 0)
    {
    print "Ja";
    }
  else
    {
    print "nein";
    }
  print "</td>";
  }

elseif($this_type == "color")
  {
  print "\n<td nowrap style='background: " . $current_entry . ";height:35px;width:50px;xtext-shadow: -1px -1px 0 #fffc;xbackground-color:#fffa;text-align: center;' class='small'>";
  print "<span style='background-color:rgba(255, 255, 255, 0.35);padding:0 0.25rem;border-radius:0.5rem;'>" . strtoupper($current_entry) . "</span>";
  print "</td>";
  }

elseif($this_type == "copy")
  {
  print "<td>";
  print "<a href='" . $_SERVER['PHP_SELF'] . "?item=" . $id . "&copyme=yes'>Eintrag kopieren</a>";
  print "</td>";
  }

elseif($this_type == $sortorder_proxy)
  {
  print "<td>";
  if ($current_entry > $sort_min)
    {
    $current_sortnumber = $$sortorder_proxy;
//echo "<br>Sortnumber: " . $current_sortnumber;
    print "<a href='" . $_SERVER['PHP_SELF'] . "?sortup=" . $current_entry . "&upd=1'><img src='images/ms_up.gif' width='17' height='16' alt='up' border='0'></a>&nbsp;";
    }
  else
    {
    print "<img src='images/14by14.gif' width='17' height='16' alt='' border='0'>&nbsp;";
    }
  if ($current_entry < $sort_max)
    {
  print "<a href='" . $_SERVER['PHP_SELF'] . "?sortdown=" . $current_entry . "&upd=1'><img src='images/ms_down.gif' width='17' height='16' alt='down' border='0'></a>";
    }
  else
    {
    print "<img src='images/14by14.gif' width='17' height='16' alt='' border='0'>&nbsp;";
    }
  //print "&nbsp;" . $current_entry;
  print "</td>";
  }

elseif($this_type == "image")
  {
  print "<td>";
  if ($current_entry != "")
    {

    print "<a class='thumbnail' href='#thumb'>";
    print "<img src='" . $downloadimages . $folder . "/" . $current_entry . "' width='20' height='20'>";
    print "<span><img src='" . $downloadimages . $folder . "/" . $current_entry . "'></span>";
    print "</a>";
    }
  else
   {
   print "&nbsp;";
   }
  //print $current_entry;
  print "</td>";
  }


elseif($this_type == "changelink")
  {
  print "<td>";
  print "<a href='delimg.php?sb=" . $ordner . "' target='_blank' rel='noopener'>Bilder ansehen / l&ouml;schen</a>";
  print "</td>";
  }

elseif($this_type == "uplink")
  {
  print "<td>";
  print "<a href='dz/index.php?sb=" . $ordner . "' target='_blank' rel='noopener'>Bilder hochladen</a>";
  print "</td>";
  }

else
  {
  print "<td>";
  print "ERROR, fieldtype: " . $this_type;
  print "</td>";
  }
      }



  print "</tr>";

  //print "</span>";

  //print "<tr>";
  //print "<td colspan='7'><img src='images/14by14.gif' width='10' height='1'></td>";
  //print "</tr>";

}

  print "</table>";


// Datenbank dichtmachen
((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
?>

<?php include "adm_footer.php"; ?>

<script>
function change(){
    document.getElementById("adminchoice").submit();
}

/*var selectcontent = document.getElementById("topmenu_selected").innerHTML;
var newselectcontent = "&crarr;&nbsp;" + selectcontent;
document.getElementById("topmenu_selected").innerHTML = newselectcontent;*/
/*document.getElementById("topmenu_selected").style = "font-weight:bold;color:#0f6f89;";*/
</script>




</body>
</html>