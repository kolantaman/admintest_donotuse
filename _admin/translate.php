<?php
foreach (array_keys($_GET) as $key) $$key=$_GET[$key];
foreach (array_keys($_POST) as $key) $$key=$_POST[$key];

// Configuration
include ("../_cd/config.php");
include ("../_functions.php");
include ("optionbox2.php");

//print "<meta NAME='author' CONTENT='Š2006 carpe diem! Werbeagentur - www.carpediem.at'>\n";
//print "<meta NAME='author' CONTENT='Alle Rechte vorbehalten'>\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
print "<!DOCTYPE html>";
print "\n<html>";
print "\n<head>";
print "\n<meta http-equiv='content-type' content='text/html; charset=iso-8859-2'>";
print "\n<link rel='stylesheet' type='text/css' href='style_translate.css'>\n";
//print "<link rel='stylesheet' type='text/css' href='../css/style.css'>\n";
//print "<script language=\"JavaScript\" src=\"calendar1.js\"></script>\n";
?>

<script type="text/javascript" src="scripts/jquery-1.3.2.js"></script>

<script type="text/javascript" src="scripts/jHtmlArea-0.7.5.js"></script>
<link rel="Stylesheet" type="text/css" href="style/jHtmlArea.css">

<?php
print "\n</head>";
print "\n\n<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0' marginwidth='0' marginheight='0'>";

// Wenn der Text geändert wurde
if ($change_entry != "")
  {
  // Datenbank öffnen
  mysql_connect($host, $username, $password) or die(mysql_error());
  mysql_select_db($database) or die(mysql_error());
  
  $post_update_fields = str_replace('\"','"',$post_update_fields);



  //print "update_fields: " . $post_update_fields . "<br>";
  $update_fields = unserialize($post_update_fields);
  //print "Shit: " . $shit . "<br>";
  $number_fields = count($update_fields);
  //print "update_fields: " . $update_fields . "<br>";
  //echo implode("-", $update_fields) . "<br>";
  //print "Anzahl Felder: " . $number_fields . "<br>";
  for ($loop=0; $loop<$number_fields; $loop++)
    {
    $arr_actual_field = explode("-",$update_fields[$loop]);
    $value_helper = $arr_actual_field[0] . "-" . $arr_actual_field[1];
    //print "Page: " . $update_page . " | ID: " . $arr_actual_field[1] . " | Field Name: " . $arr_actual_field[0] . " | Field Value: " . $$value_helper . "<br><br>";

    $fieldcontent_to_write = $$value_helper;

    $fieldcontent_to_write = str_replace("'","&rsquo;",$fieldcontent_to_write);

    $fieldcontent_to_write   = ConvertUmlauts($fieldcontent_to_write);

    $query = "UPDATE $table_lang SET " . $arr_actual_field[0] . " = '" . $fieldcontent_to_write . "' WHERE id='" . $arr_actual_field[1] . "'";
    //print $query . "<br>";   
    $result = mysql_query($query) or die(mysql_error());
    }
  }


// Beim ersten Aufruf, oder nach erfolgter Änderung: Seitenauswahl anzeigen
if ($translate_page == "" OR $translate_page == "none")
  {
?>
<form name='form_translate' method='post' action='<?php echo $PHP_SELF ?>'><br>
<table bgcolor='#FFFFFF' border='0' cellspacing='0' cellpadding='3' align='center' class='boundbox'>
  <tr>
    <td class='tablehead'>&nbsp;Seite übersetzen:</td>
  </tr>
  <tr>
    <td align='center'><select name='translate_page'><?php echo dropbox("content", "con_seite", "con_seitentitel", "$translate_page", "Bitte wählen Sie die gewünschte Seite...") ?></select>
    </td>
  </tr>
  <tr>
    <td align='center'>
    <input type='radio' <?php if($translation_direction=='deen' or $translation_direction=='') echo ' checked '?> value='deen' name='translation_direction'>&nbsp;deutsch->englisch&nbsp;&nbsp;
    <input type='radio' <?php if($translation_direction=='ende') echo ' checked '?>value='ende' name='translation_direction'>&nbsp;englisch->deutsch&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
    <td align='center'><input type='submit' value='&nbsp;Auswählen...&nbsp;'></td>
  </tr>
</table>
</form>
<?php
  }

// Wenn die Seite und die Übersetzungsrichtung gewählt wurde, Felder zum Übersetzen auflisten
if ($translate_page != "" AND $translate_page != "none")
  {
  // Die Übersetzungsrichtung festlegen
  $translate_from = substr($translation_direction,0,2);
  $translate_to   = substr($translation_direction,-2);
  
  // Datenbank öffnen
  mysql_connect($host, $username, $password) or die(mysql_error());
  mysql_select_db($database) or die(mysql_error());
  
  // default-order: vorgegebene Reihenfolge
  if($order == "")
  {
  $order = "con_seite";
  }
  
  // Alles auswählen
  $formstring = "";

  $query = "select * from $table_lang WHERE con_seite='" . $translate_page . "' order by $order asc";    
  $result = mysql_query($query) or die(mysql_error());
  // Anzahl der Datensätze
  $number = mysql_num_rows($result);
  //print $number . "<br>";
  $formstring .= "\n<form name='form_translate' method='post' action='" . $PHP_SELF . "'><br>";
  $formstring .= "\n<table border='0' cellspacing='0' cellpadding='0' align='center' width='810'>";
  $formstring .= "\n<tr>";
  $formstring .= "\n<td colspan='2' class='tablehead'>&nbsp;<a href='translate.php'>Administration</a>&nbsp;-&nbsp;Übersetzeransicht: " . $translate_from . "->" . $translate_to .  "&nbsp;(" . $translate_page . ")</td>";
  $formstring .= "\n</tr>";
  //print "<tr><td colspan='2' class='divider'>&nbsp;</td></tr>";
  
  // Array mit dem die übergebenen Feldnamen ausgewertet werden
  $arr_update_fields = array();
  
  // Pro Datensatz wird eine Tabellenzeile geschrieben
  for ($i = 0; $i < $number; $i++)
    {
    // Variable entsprechend den Feldnamen werden erstellt
    $fields = count(mysql_fetch_row($result));
    for ($f = 0; $f < $fields; $f++)
      {
      $var = mysql_field_name($result,$f);
      $$var = mysql_result($result, $i, $var);
      }


    // TEXT
    if ($con_type == "text")
      {
      //echo $translate_to;
      $to_field_name  = "con_data_" . $translate_to . "-" . $id;
      $to_field_value = "con_data_" . $translate_to;
      $from_field_name  = "con_data_" . $translate_from . "-" . $id;
      $from_field_value = "con_data_" . $translate_from;
      $formstring .= "\n\n<tr><td colspan='2'>&nbsp;</td></tr>";
      $formstring .= "\n<tr><td colspan='2' class='divider'><img src='images/arrow_down.gif' width='14' height='20' align='left'>&nbsp;<i>Interner Bezeichner:</i>&nbsp;<b>" . $con_bezeichner . "</b></td></tr>";
      $formstring .= "\n<tr><td class='otr_label'>Original:&nbsp;</td><td class='otr_data'>" . $$from_field_value . "</td></tr>";
      $formstring .= "\n<tr><td class='utr_label'>Übersetzung:&nbsp;</td><td class='utr_data'><input type='text' size='50' name='" . $to_field_name . "' value='" . $$to_field_value . "'></td></tr>";
      $foo = array_push($arr_update_fields,$to_field_name);
      }
      
      

    // HTML
    else if ($con_type == "html")
      {
      $to_field_name  = "con_data_" . $translate_to . "-" . $id;
      $to_field_value = "con_data_" . $translate_to;
      $from_field_name  = "con_data_" . $translate_from . "-" . $id;
      $from_field_value = "con_data_" . $translate_from;
      $formstring .= "\n\n<tr><td colspan='2'>&nbsp;</td></tr>";
      $formstring .= "\n<tr><td colspan='2' class='divider'><img src='images/arrow_down.gif' width='14' height='20' align='left'>&nbsp;<i>Interner Bezeichner:</i>&nbsp;<b>" . $con_bezeichner . "</b></td></tr>";
      $formstring .= "\n<tr><td class='otr_label'>Original:&nbsp;</td><td class='otr_data'>" . $$from_field_value . "</td></tr>";
      $formstring .= "\n<tr><td class='utr_label'>Übersetzung:&nbsp;</td><td class='utr_data'>";

      $formstring .= "\n<textarea id='" . $to_field_name . "' name='" . $to_field_name . "' style='width:800px;height:450px;'>" . $$to_field_value . "</textarea>";

      $formstring .= "\n</td></tr>";
      $foo = array_push($arr_update_fields,$to_field_name);
     
       $initializer .= "
        \n\n<script type=\"text/javascript\">
        $(function(){
        $('#" . $to_field_name . "').htmlarea({css:'style//mine.css'})
        });
        </script>\n\n
        ";
      }
    }
  $formstring .= "\n\n<tr><td colspan='2' align='center'><br><input type='submit' name='change_entry' value='&nbsp;Änderungen speichern&nbsp;'>";
  $formstring .= "\n<input type='hidden' name='update_page' value='" . $translate_page . "'>";
  $formstring .= "\n<input type='hidden' name='post_update_fields' value='" . serialize($arr_update_fields) . "'>";
  $formstring .= "\n</td></tr>";
  $formstring .= "\n</table><br><br><br>";
  $formstring .= "\n</form>";
  }


echo $initializer;
echo $formstring;

?>


</body>
</html>




