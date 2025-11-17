<?php
session_start();
ob_start();
//error_reporting(0);
error_reporting(E_ALL);
// Nur einfache Fehler melden
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//echo "<br><br>###<br>galerie: ";
//var_dump($_POST);

// ### Dictionary Decode ### //
  // JSON dictionarylesen
/*  $json_filename = "../_includes/_de_translation.json";
  //echo "<br>#" . $json_filename . "#<br>";
  $jsonfile = fopen($json_filename, "r") or die("Dictionary Datenfile nicht vorhanden");
  $json = fread($jsonfile,filesize($json_filename));
  fclose($jsonfile);
  $cdata = json_decode(str_replace("#shy#", "**&shy;", $json), true);
  extract($cdata);*/

$item = $_GET['item'];
$adminarea = $_GET['adminarea'];
//error_reporting(E-ALL);

if(session_id() == '')
  {
  //echo "do is koa session nit<br>";
  }
else
  {
  //echo "what a mighty fine session you got here<br>";
  }


include ("../_cd/config.php");

  if ($_SESSION['this_adminarea'] != "")
    {
    $this_plugin = "plugin/_plugin_" . strtolower($_SESSION['this_adminarea']) . ".php";
    }
  else
    {
    $this_plugin = "plugin/_plugin_" . strtolower($section_default) . ".php";
    }
  include $this_plugin;



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



// Includes
if($use_functions==1){require "_functions.php";}
if($use_bigpicture==1){require "big_picture.php";}
if($use_optionbox==1){require "optionbox.php";}

foreach (array_keys($_GET) as $key) $$key=sanitize($_GET[$key]);
foreach (array_keys($_POST) as $key) $$key=sanitize($_POST[$key]);

function filename_clean($filename)
  {
  $file_from = array("ä",  "ö",  "ü",  "ß", "Ä",  "Ö",  "Ü",  "ß", "Ã¤",  "Ã¶",  "Ã¼",  "ÃŸ",  "%20", "\"", "\'", "Â´", "`", "=", ",", ";", "§", "  ", " ", " – ", "–");
  $file_to = array("ae", "oe", "ue", "ss", "Ae", "Oe", "Ue", "ss", "ae", "oe", "ue", "ss", "_",   "",   "",   "",  "",  "",  "",  "", "", "pg", " ",  "_", "-", "-");

  $replacements = count($file_from);

  for ($r=0;$r<$replacements;$r++)
    {
    $filename = str_replace($file_from[$r],$file_to[$r],$filename);
    }

  return strtolower($filename);
  }


//echo "plugin: " . $this_plugin . "<br>";
//echo "item: " . $item . "<br>";
//echo "adminarea: " . $adminarea . "<br>";
//echo "Table: " . $table_used . "<br>";


/* ### Custom Assets ### */
//include "plugin/_custom_assets.php";

if($use_doubledigit == 1)
  {
  $newbild01 = "new_" . $bild_proxy . "01";
  $newbild02 = "new_" . $bild_proxy . "02";
  $newbild03 = "new_" . $bild_proxy . "03";
  $newbild04 = "new_" . $bild_proxy . "04";
  $newbild05 = "new_" . $bild_proxy . "05";
  }
else
  {
  $newbild01 = "new_" . $bild_proxy;
  $newbild02 = "new_" . $bild_proxy;
  $newbild03 = "new_" . $bild_proxy;
  $newbild04 = "new_" . $bild_proxy;
  $newbild05 = "new_" . $bild_proxy;
  }

//echo "Proxy: " . $newbild01 . "<br>";

//$upload_bildname1 = $_FILES[$newbild01]['tmp_name'];
//$upload_bildname2 = $_FILES[$newbild02]['tmp_name'];
//$upload_bildname3 = $_FILES[$newbild03]['tmp_name'];
//$upload_bildname4 = $_FILES[$newbild04]['tmp_name'];
//$upload_bildname5 = $_FILES[$newbild05]['tmp_name'];

// filename de
$file_name = $_FILES['file']['name'];
$tempfile  = $_FILES['file']['tmp_name'];
$orifile = $_POST['orifile'];
// blank or no change
if($file_name == "" AND $orifile == "") {$file = "";}
// new file or overwrite
if($file_name != "") {$file = filename_clean($file_name);}
// keep original file
if($file_name == "" AND $orifile != "") {$file = $orifile;}


//echo "<br>filename_sk: *" . $file_name_sk . "*<br>";
//$file_name = $_FILES[file][name];
//$tempfile  = $_FILES[file][tmp_name];


//echo "Oribildname: " . $_FILES[new_pgbild][tmp_name] . "<br>";
//echo "Uploadbildname: " . $upload_bildname1 . "<br>";

if ($submit != "")
  {

//echo "<br>Tempfile: " . $tempfile . "<br>Target: " . $downloadfolder . $file . "<br>";

if($file != "" AND $tempfile != "")
  {
  copy($tempfile,$downloadfolder . $file);
  }
}

//echo "<br>file_proxy_de: " . $file_proxy_de;
//echo "<br>file_proxy_en: " . $file_proxy_en;
//echo "<br>file_proxy_cz: " . $file_proxy_cz;
//echo "<br>file_proxy_sk: " . $file_proxy_sk . "<br>";

$db_count = count($db_fields);

// Feststellen wieviele Bilder es gibt
for ($loop=0; $loop<$db_count; $loop++)
  {
  if ($db_type[$loop] == "image")
    {
    $number_images++;
    }
  }
//echo "Es gibt " . $number_images . " Bilder";


// -----------------------------------------------------------------
// Datenbank öffnen
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database);

// Eintrag löschen
if ($delete_entry == 1)
  {
  $query = "delete from " . $table_used . "  where " . $id_proxy . " like $item";
  //echo $query;
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  // Datenbank dichtmachen
  @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
  header("Location: admin.php?upd=1");
  }

// Änderung durchführen
if ($submit != "")
  {

  //echo "Foo: " . $html_text_de . " (" . $headline_de . " / " . $html_text_en . ")<br>";
  //echo "<br>Rawimage: " . $rawimage;
  //break;

//echo "dbcount: " . $db_count . "<br>";

//for($foo=0;$foo<$db_count;$foo++)
  {
  //echo "Foo: " . $foo . "<br>";
  }
  //break;


    // Wenn eine neue kategorie gewählt wurde
    for ($katloop=0;$katloop<$db_count;$katloop++)
    {
      $current_helper = $db_fields[$katloop];
      $current_entry = $$current_helper ;

      //echo "Current Field = " . $current_helper . "<br>";

      $newkat_helper = "new_" . $db_fields[$katloop];
      $newkat_entry = $$newkat_helper ;

      //echo "Newkat Entry = " . $newkat_entry . "<br>";

    if ($newkat_entry != "")
        {
        //echo "nke: " . $newkat_entry . "<br>";
        $$current_helper = $newkat_entry;
        }
    }


  // Wenn es ein Update ist
  if ($item != "")
    {
    $delete_file = $_POST['delete_file'];

//echo "Delete File: " . $delete_file;
//break;

    // Update (noch ohne Bild)

//echo "**<br>" . $file_proxy_de . " = " . $$file_proxy_de;
//echo "<br>" . $file_proxy_en . " = " . $$file_proxy_en;
//echo "<br>" . $file_proxy_cz . " = " . $$file_proxy_cz;
//echo "<br>" . $file_proxy_sk . " = " . $$file_proxy_sk;

    $query = "update " . $table_used . " set ";
    for ($dbf=0; $dbf<$db_count; $dbf++)
      {
      $current_helper = $db_fields[$dbf];
      $current_entry = $$current_helper ;

  // hack bw, remove uplink, changelink, 230310
    if($current_helper != "changelink" AND $current_helper != "uplink")
      {

//echo "<br>current_helper: " . $current_helper;

      // Datum umwandeln falls vorhanden
      if (substr($db_type[$dbf],0,4) == "date")
        {
        $act_j = intval(substr($current_entry,6,4));
        $act_m = intval(substr($current_entry,3,2));
        $act_t = intval(substr($current_entry,0,2));
        $current_entry = mktime(0,0,0,$act_m,$act_t,$act_j);

        if($current_entry < "950000000")
          {
          $current_entry = "0";
          }
        }

// HTML field replace unwanted characters
      if ($db_type[$dbf] == "html")
        {
        $current_entry = str_replace('<div>', '<p>', $current_entry);
        $current_entry = str_replace('</div>', '</p>', $current_entry);
        $current_entry = str_replace('<span style="font-size: 14.44px;">', '', $current_entry);
        $current_entry = str_replace('<span style="">', 'foo###foo', $current_entry);
        $current_entry = str_replace('<span style=>', '', $current_entry);
        $current_entry = str_replace('</span>', '', $current_entry);
        $current_entry = str_replace("<p><br></p>", "", $current_entry);
        }

      // Timeframe (events) abfangen
      if($timeframe == "") {$timeframe = "0";}

      // Weblink
      if($db_type[$dbf] == "weblink" OR $db_type[$dbf] == "vlink" OR $db_type[$dbf] == "extlink")
        {
        $reworked_link = str_replace("https://", "", $current_entry);
        $reworked_link = str_replace("http://", "", $reworked_link);
        $current_entry = $reworked_link;
        //echo "<br>" . $db_fields[$dbf] . " = " . $$db_fields[$dbf] . "<br>";
        }

      // Checkboxen imploden chk
      if (substr($db_type[$dbf],0,3) == "chk" OR substr($db_type[$dbf],0,3) == "fch" OR substr($db_type[$dbf],0,3) == "zch" OR substr($db_type[$dbf],0,3) == "chf" OR substr($db_type[$dbf],0,3) == "chx")
        {
          var_dump($current_entry);
        $current_entry = implode("|", $current_entry);

        //$current_entry = "this should not happen";
        //echo "here we go:<br>";
        //print_r($hhelper);
        //print_r($current_entry);
        //break;
        }

      // Bilder nicht schreiben
      if ( $db_type[$dbf] != "image" )
        {$query .= $db_fields[$dbf] . " = '" . ConvertUmlauts($current_entry) . "', ";
        }

//echo substr($db_type[$dbf],0,3) . "<br>";

        } // hack bw, remove uplink, changelink, 230310, EOF
      }
//break;
    // Letzten Beistrich abschneiden
    $query = substr($query,0,-2);

    $query .= " where $id_proxy like '$item'";
    //print $query;
    //break;
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

  // Neuanlage
  else
    {
    $query = "insert into " . $table_used . " (";

      for ($dbf=0; $dbf<$db_count; $dbf++)
        {
  // hack bw, remove uplink, changelink, 230310
    //echo "<br>firstpart dbf: " . $db_fields[$dbf] . "<br>";
    if($db_fields[$dbf] != "changelink" AND $db_fields[$dbf] != "uplink")
      {

        $query .= $db_fields[$dbf] . ", ";
        }
      }   // hack bw, remove uplink, changelink, 230310 EOF

    // Letzten Beistrich abschneiden
    $query = substr($query,0,-2);

    $query .= ") values (";

    for ($dbf=0; $dbf<$db_count; $dbf++)
      {
      $current_helper1 = $db_fields[$dbf];
      $current_entry1 = $$current_helper1;

//echo "current_helper1 " . $current_helper1 . "<br>";
//echo "db_type " . $db_type[$dbf] . "<br>";


      // Aktiv abfangen
      if ($db_type[$dbf] == "rad_aktiv")
        {
        $current_entry1 = intval($current_entry1);
        }

// HTML field
      if ($db_type[$dbf] == "html")
        {
        $current_entry1 = str_replace('<div>', '<p>', $current_entry1);
        $current_entry1 = str_replace('</div>', '</p>', $current_entry1);
        $current_entry1 = str_replace('<span style="font-size: 14.44px;">', '', $current_entry1);
        $current_entry1 = str_replace('<span style="">', 'foo###foo', $current_entry1);
        $current_entry1 = str_replace('<span style=>', '', $current_entry1);
        $current_entry1 = str_replace('</span>', '', $current_entry1);
        $current_entry1 = str_replace("<p><br></p>", "", $current_entry1);
        }

      // Datum umwandeln falls vorhanden
      if (substr($db_type[$dbf],0,4) == "date")
        {
        $act_j = intval(substr($current_entry1,6,4));
        $act_m = intval(substr($current_entry1,3,2));
        $act_t = intval(substr($current_entry1,0,2));
        $current_entry1 = mktime(0,0,0,$act_m,$act_t,$act_j);

        if($current_entry1 < "950000000")
          {
          $current_entry1 = "0";
          }
        }

      // Weblink
      if($db_type[$dbf] == "weblink" OR $db_type[$dbf] == "vlink" OR $db_type[$dbf] == "extlink")
        {
        $reworked_link = str_replace("https://", "", $current_entry1);
        $reworked_link = str_replace("http://", "", $reworked_link);
        $current_entry1 = $reworked_link;
        //echo "<br>" . $db_fields[$dbf] . " = " . $$db_fields[$dbf] . "<br>";
        }

      // Timeframe (events) abfangen
      if($timeframe == "") {$timeframe = "0";}

      // Checkboxen imploden chk
      if (substr($db_type[$dbf],0,3) == "chk" OR substr($db_type[$dbf],0,3) == "fch" OR substr($db_type[$dbf],0,3) == "zch" OR substr($db_type[$dbf],0,3) == "chf" OR substr($db_type[$dbf],0,3) == "chx")
        {
          var_dump($current_entry1);
        $current_entry1 = implode("|", $current_entry1);

        //$current_entry = "this should not happen";
        //echo "here we go:<br>";
        //print_r($hhelper);
        //print_r($current_entry);
        //break;
        }

  // hack bw, remove uplink, changelink, 230310
    if($db_fields[$dbf] != "changelink" AND $db_fields[$dbf] != "uplink")
      {
      $query .= "'" . ConvertUmlauts($current_entry1) . "', ";

      } // hack bw, remove uplink, changelink, 230310, EOF

}
    // Letzten Beistrich abschneiden
    $query = substr($query,0,-2);

    $query .= ")";

    //echo "Date Start = #" . $date_start . "#<br>";
    //echo "Date End = #" . $date_end . "#<br>";
    print "Query: " . $query . "<br><br>";

    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // id feststellen, damit das Bild benannt werden kann
    $item = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    }

    // Sortkey
    if($sortkey != "")
      {
      $current_helper1 = $sortkey;
      $current_entry_key = $$current_helper1;
      $current_entry_key = strtolower(ConvertUmlauts($current_entry_key));

      // 3-letter sortkey
      $sl_from = array("&auml;", "&ouml;", "&uuml;", "&szlig;", "ä",  "ö",  "ü",  "ß", "Á","á","A","a","É","é","E","e","E","e","Í","í","Ó","ó","Ô","ô","Ú","ú","U","u","Ý","ý","C","c","d","t","L","l","N","n","R","r","R","r","Š","š","Ž","ž");
      $sl_to   = array("a",  "o", "u", "ss", "ae", "oe", "ue", "ss", "a","a","a","a","e","e","e","e","e","e","i","i","o","o","o","o","u","u","u","u","y","y","c","c","d","t","l","i","n","n","r","r","r","r","s","s","z","z");

      $sl_replacements = count($sl_from);

      if(count($sl_from) != count($sl_to))
        {
        //echo "Array Mismatch!";
        //echo "<br>SL from: " . count($sl_from) . " entries";
        //echo "<br>SL to: " . count($sl_to) . " entries";
        //break;
        }

      for ($sr=0;$sr<$sl_replacements;$sr++)
        {
        $current_entry_key = str_replace($sl_from[$sr],$sl_to[$sr],$current_entry_key);
        }

        $use_sortkey = substr($current_entry_key,0,3);


      //echo "substr: " . strtolower(substr($current_entry_key,0,6)) . "<br>";
      //echo "usethis: " . $use_sortkey . "<br>";

        $keysql = "UPDATE " . $table_used . " SET sortletter = '" . $use_sortkey . "' WHERE " . $id_proxy . " LIKE " . $item;
        //echo $keysql;
        //break;
        $keyresult = mysqli_query($GLOBALS["___mysqli_ston"], $keysql)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      }



  // ##############################
  // Bild verarbeiten und schreiben
  // ##############################


  //echo "Number of images: " . $number_images . "<br>";
  //break;
  include_once("class_resize_image.php");

  for ($loop_images=1; $loop_images<=$number_images; $loop_images++)
  {
  //echo "Loop " . $loop_images . "<br>";
  //break;

  // Zähler zweistellig machen
  if ($use_doubledigit == 1)
    {
    $twodigit_counter = substr(("00" . $loop_images), -2);
    }
  else
    {
    $twodigit_counter = $loop_images;
    }

  // Das aktuelle Bild
  $new_rawname = $bild_proxy . $twodigit_counter; // Der Name des Formularfeldes (neues Bild)
  //echo "New Rawname: " . $new_rawname . "<br>";
  //echo "New Newbildname1: " . $upload_bildname1 . "<br>";


  $rawname = $bild_proxy . $twodigit_counter; // Der Feldname

  $rawimage = $$new_rawname; // Der Inhalt des Formularfeldes
  $fldn = ${"newbild" . $twodigit_counter};
  $rhelper = $_FILES[$fldn]['tmp_name'];
  $rawimage = $rhelper;
  $fileext = end((explode(".", $_FILES[$fldn]['name']))); # extra () to prevent notice

//$upload_bildname1 = $_FILES[$newbild01]['tmp_name'];

  //echo "fldn: " . $fldn . "<br>";
  //echo "Rawname: " . $rawname . "<br>";
  //echo "Rawimage: " . $rawimage . "<br>";
  //echo "Fileext: " . $fileext . "<br>";
  //break;

  if ($rawimage != "none" AND $rawimage != "")
    {
    // small image
    $resize = new ResizeImage($rawimage);
    $resize->resizeTo($images_width, $images_width, 'maxWidth');
    $rbild = "bild_" . $item . "_" . $twodigit_counter . "." . $fileext;
//echo "<br>#: " . $rawimage . "<br>";
//echo "<br>#: " . $rbild . "<br>";
    $resize->saveImage($downloadimages . $rbild);

    // big image
    if($use_bigpicture == 1)
      {
      $resizebig = new ResizeImage($rawimage);
      $resizebig->resizeTo($bigimages_width, $bigimages_height, 'maxWidth');
      $brbild = "bild_" . $item . "_" . $twodigit_counter . "." . $fileext;
  //echo "<br>b#: " . $rawimage . "<br>";
  //echo "<br>b#: " . $rbild . "<br>";
      $resizebig->saveImage($downloadbigimages . $brbild);
      }

    // Und jetzt das Bild mit dem korrekten Namen in die DB schreiben ...
    $query = "update " . $table_used . " set " . $rawname . "='" . $rbild . "' where " . $id_proxy . "=" . $item;
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

  // Wenn Bild zum L&ouml;schen ausgewählt wurde
  $delete_helper = "delete_" . $rawname;
  //print "dh: " . $delete_helper . ", Value: " . $$delete_helper;
  if ($$delete_helper == 1)
    {
    // Filename feststellen
    $fnquery = "SELECT " . $rawname . " FROM $table_used WHERE " . $id_proxy . "=" . $item;
    $fnresult = mysqli_query($GLOBALS["___mysqli_ston"], $fnquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    $fnrow = mysqli_fetch_row($fnresult);
    extract($fnrow);
    //echo "<br>fnquery: " . $fnquery;

    // Biddateien löschen
    unlink($downloadimages . $fnrow[0]);
    unlink($downloadbigimages . $fnrow[0]);

    // Bild löschen
    $query = "update " . $table_used . " set " . $rawname . "='" . $rbild . "' where " . $id_proxy . "=" . $item;

//echo "<br><br>qr: " . $query;
//echo "<br>rn: " . $rawname;
//echo "<br>rb: " . $rbild;
//break;
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }
  }

  // Wenn das File zum L&ouml;schen ausgew&auml;hlt wurde
  if ($delete_file != "")
    {
    //echo "BOO!";
    //break;
    // File löschen
    $query = "update " . $table_used . " set file = '' where " . $id_proxy . "=" . $item;
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    unlink($downloadfolder . "" . $file);
    }


//echo "no loop<br>";
//break;

  // Datenbank dichtmachen
  @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

  // Zur&uuml;ck zur Administration
  //print "deswors";
  header("Location: admin.php?upd=1");
  //exit;
  //print "noned";


  }
  else
  {

  if ($result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from $table_used where " . $id_proxy . " like $item"))
    {
    $row = mysqli_fetch_assoc($result);
    extract($row);
    ((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
    }


//<!-- ### Formular generieren ### -->
// Beginn Formular
  $fullform = "";
  $initializer = "";

for ($dbf=0; $dbf<$db_count; $dbf++)
  {
  // ### Verschiedene Feldarten generieren ### //
  include "plugin/_custom_fields.php";
  // ### Verschiedene Feldarten generieren ### //

  $fullform .= "<tr><td nowrap valign='top' align='right' class='tablehead'>&nbsp;<b>" . $db_labels[$dbf] . "</b>:&nbsp;</td><td class='form_inputsection'>" . $input_item . "</td></tr>";
  }
}

// Blank Row
  $fullform .= "<tr><td colspan='2'>&nbsp;</td></tr>";

// Abschicken
  $fullform .= "
  <tr>
  <td align='center' colspan='2'>
  <input type='hidden' name='item' value='" . $item . "'>";

  $fullform .= $hiddenfields;
  //$fullform .= "####";
  //print "<input type='hidden' name='bild' value='" . $bild . "'>";

  // Send-Button Neuanlage oder &Auml;nderung ?
  if ($item != "")
    {
    $buttontext = $this_topic_s . " &auml;ndern";
    }
  else
    {
    $buttontext = $this_topic_s . " anlegen";
    }

  // View only oder Ã¤nderbar
  if($view_only == 1)
    {
    $fullform .= "<br><b>Nur zur Ansicht</b><br><a href='admin.php'>Zur&uuml;ck zur Administration</a>
  </td></tr>";
    }
  else
    {
    $fullform .= "<br><br><input type='submit' name='submit' value=' " . $buttontext . " '>
  </td></tr>";
    }

// Datenbank dichtmachen
@((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1_german2_ci">
<meta charset="latin1_german2_ci">
<title>Administration</title>
<meta NAME='author' CONTENT='&copy;2002 carpe diem! Werbeagentur - www.carpediem.at'>
<meta NAME='author' CONTENT='Alle Rechte vorbehalten'>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<?php
if($use_calendar==1)
{
echo "<script language='JavaScript' src='calendar1.js'></script>\n";
}?>
<script type="text/javascript" src="scripts/jquery-1.3.2.js"></script>

<script type="text/javascript" src="scripts/jHtmlArea-0.7.5.js"></script>
<link rel="Stylesheet" type="text/css" href="style/jHtmlArea.css">

</head>

<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0' marginwidth='0' marginheight='0'>

<?php
echo $initializer;
?>

<!-- Tabellenbeginn ausgeben -->
<form name='news' id='mainform' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype='multipart/form-data'>
<table bgcolor='#F7F7FF' align='center' class='boundbox admintable'>

<!-- Überschrift -->
<tr><td colspan='2' class='tableheadtop'>

<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr>
<td class='tableheadtop'>&nbsp;<a href='admin.php' class='tableheadtop'>Administration</a>&nbsp;-&nbsp;<?php echo $this_topic_p ?> verwalten</td>
<td align='right' class='tableheadtop'>

<?php if($block_delete != "yes")
  {
  ?>
<input type='checkbox' name='delete_entry' id='delete_entry' value='1'>
&nbsp;&nbsp;Diesen Eintrag l&ouml;schen

<?php
  }
  ?>

&nbsp;&nbsp;</td>
</tr>
</table>
</td>
</tr>

<!-- Blank Row -->
<tr><td colspan='2'>&nbsp;</td></tr>

<?php
echo $fullform;
?>

<tr>
<td colspan='2'>&nbsp;</td>
</tr>
</table>
</form>

<?php
if($use_calendar == 1)
  {
  echo "
  <script type='text/javascript'>
  <!--
  // create calendar object(s) just after form tag closed
  // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
  // note: you can have as many calendar objects as you need for your application
  ";

  $cal_count = 1;
  foreach($names_calendars AS $this_cal)
    {
    echo "
    var cal" . $cal_count . " = new calendar1(document.forms['news'].elements['" . $this_cal . "']);
    cal" . $cal_count . ".year_scroll = true;
    cal" . $cal_count . ".time_comp = false;
    ";
    $cal_count++;
    }


  echo "
  //-->
  </script>
";
  }


if($view_only == 1)
  {
  echo "
  <script type='text/javascript'>
  <!--
  ";
    echo "
    $('#mainform input').attr('disabled', 'true');
    $('#mainform input:radio').css('display', 'none');
    $('#mainform input').css('opacity', '1');
    $('#mainform input:radio:checked').css('display', 'inline-block');
    $('#mainform input:radio:checked').css('border', '2px solid #00AD03');
    $('#mainform input:radio:checked').css('background', '#00AD03');
    $('#mainform #delete_entry').attr('disabled', 'false');
    ";

  echo "
  //-->
  </script>
";
  }

function showDuration($duration_sec) {
    if ($duration_sec >= 86400) {
        $days = floor($duration_sec / 86400); // get number of whole days
        $duration_sec %= 86400; // get remaining seconds after subtracting days
    }

    if ($duration_sec >= 3600) {
        $hours = floor($duration_sec / 3600); // get number of whole hours
        $duration_sec %= 3600; // get remaining seconds after subtracting hours
    }

    if (isset($hours) || $duration_sec >= 60) {
        $minutes = floor($duration_sec / 60); // get number of whole minutes
        $duration_sec %= 60; // get remaining seconds after subtracting minutes
    }

    $seconds = $duration_sec; // remaining seconds

    $output = "";

    if (isset($days)) {
        $output .= "$days Tag" . ($days > 1 ? "e" : "") . ", ";
    }

    if (isset($hours)) {
        $output .= "$hours Stunde" . ($hours > 1 ? "n" : "") . ", ";
    }

    if (isset($minutes)) {
        $output .= "$minutes Minute" . ($minutes > 1 ? "n" : "") . ", ";
    }

    $output .= "$seconds Sekunde" . ($seconds > 1 ? "n" : "");

    return rtrim($output, ", "); // remove trailing comma and space
}

ob_end_flush();
?>

</body>
</html>