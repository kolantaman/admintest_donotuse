<?php
//error_reporting(E_ALL);
  $current_helper = $db_fields[$dbf];
    $current_entry = $$current_helper ;


//echo "<br>dbtype: #" . $db_type[$dbf] . "#<br>";

/*
################################
### TEXT ###
################################
 */
  // TEXT
  if ($db_type[$dbf] == "text")
    {
    $autofocus = "autofocus='autofocus'";
    $input_item = "<input type='text' " . $autofocus . " size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    }



  // VIEW
  elseif ($db_type[$dbf] == "view")
    {
    $input_item = "\n\n&nbsp;<span class='viewfield'>" . $current_entry . "</span>";
    }

  // VIEW BOXED
  elseif ($db_type[$dbf] == "vieb")
    {
    $input_item = "\n\n&nbsp;<div class='viewfield_boxed'>" . $current_entry . "</div>";
    }


/*
################################
### TEXT LOWERCASE ###
################################
 */
  // TEXT lowercase
  elseif ($db_type[$dbf] == "text_low")
    {
    $autofocus = "autofocus='autofocus'";
    $input_item = "<input type='text' " . $autofocus . " onkeyup='this.value = this.value.toLowerCase();' size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    }

/*
################################
### TEXT WITH OPTIONS ###
################################
 */
  // TEXT with options
  elseif ($db_type[$dbf] == "dl_text")
    {
    $autofocus = "autofocus='autofocus'";
    $input_item = "<input type='text' " . $autofocus . " size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "' list='" . $db_fields[$dbf] . "'>";

    $arr_options = ${"dl_" . $db_fields[$dbf] . "_options"};
    $input_item .= "<datalist id=\"" . $db_fields[$dbf] . "\">";
    foreach($arr_options AS $this_option)
      {
      $input_item .= "<option value=\"" . $this_option . "\">";
      }
    $input_item .= "</datalist";
    $input_item .= "&nbsp;";
    }

/*
################################
### TEXT PREFILLED###
################################
 */
  // TEXT PREFILLED
  elseif ($db_type[$dbf] == "pre_text")
    {
    if ($db_fields[$dbf] != "") {$pre_text = $current_entry;}
    $input_item = "<input type='text' size='50' name='" . $db_fields[$dbf] . "' value='" . $pre_text . "'>&nbsp;";
    }

/*
################################
### INTEGER ###
################################
 */
  // INTEGER
  elseif ($db_type[$dbf] == "int")
    {
      if($current_entry == "")
        {$current_entry=0;}
    $input_item = "\n\n<input type='text' size='20' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;&lt;- Nur <b>ganze Zahlen</b> ohne Sonderzeichen!";
    }

/*
################################
### CURRENT DATE ###
################################
 */
  // CURRENT DATE
  elseif (($db_type[$dbf]) == "curdate")
    {
      //echo "<script>alert('foo!')</script>";
      if($current_entry == "")
        {$current_entry=0;}
    $input_item = "\n\n<input type='text' size='20' class='viewfield' name='" . $db_fields[$dbf] . "' value='" . time() . "' disabled>";
    }

/*
################################
### IMAGE ###
################################
 */
  // IMAGE
  elseif (substr($db_type[$dbf],0,5) == "image")
    {
    $input_item = "\n\n<input type='file' size='30' name='new_" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    if ($current_entry != "")
      {
      $input_item .= "<input type='checkbox' name='delete_" . $db_fields[$dbf] . "' value='1'>&nbsp;Bild l&ouml;schen&nbsp;";
      $input_item .= "&nbsp;&nbsp;<a class='thumbnail' href='#thumb'>";
      $input_item .= "<img src='" . $downloadimages . $current_entry . "' width='auto' height='20'>";
      $input_item .= "<span><img src='" . $downloadimages . $current_entry . "'></span></a>";
      }
    $rbild = $current_entry;
    $input_item .= "<input type='hidden' name='old_" . $db_fields[$dbf] . "' value='$db_fields[$dbf]'>";
    //$input_item .= "<input type='hidden' name='rbild' value='$bild'>";
    }

/*
################################
### COLOR ###
################################
 */
  // Color
  elseif ($db_type[$dbf] == "color")
    {
    if ($db_fields[$dbf] != "") {$pre_text = $current_entry;}
    $input_item = "\n\n<div style='background: " . $db_fields[$dbf] . ";height:35px;width:50px;text-shadow:(1px 1px 0 #fff);'>";
    $input_item .= $db_fields[$dbf];
    $input_item .= "</div>";
    }

/*
################################
### FILE ###
################################
 */
  // FILE
  elseif ($db_type[$dbf] == "file")
    {
    // extract current language of filefield for downloadfolder
    $this_filelanguage = substr($db_fields[$dbf],-2);
    $input_item = "&nbsp;<b>Datei zum HOCHLADEN (z.B. PDF)</b><br>";

    $input_item .= "<input type='file' size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";

    if ($current_entry != "")
      {
      $input_item .= "<input type='checkbox' name='delete_file' value='" . $this_filelanguage . "'>Datei l&ouml;schen&nbsp;";
      }

    $input_item .= "<input type='hidden' name='ori" . $db_fields[$dbf] . "' value='" . $current_entry . "'>";

    $input_item .= "<br>&nbsp;<span class='small'>Derzeit verlinktes File: ";
    if($current_entry != "")
      {
      $input_item .= "<a href='" . ${"downloadfolder_" . $this_filelanguage} . "/" . $current_entry . "' target='_blank'><b>". $current_entry . "</b></a></span>";
      }
    else
      {
      $input_item .= "keines</span>";
      }
    }

/*
################################
### VIDEO ###
################################
 */
  // VIDEO
  elseif ($db_type[$dbf] == "vlink")
    {
    $input_item = "<br>&nbsp;<b>VOLLST&Auml;NDIGER Link zum Video (https://...)</b><br>";
    $input_item .= "<input type='text' size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    }

/*
################################
### LINK INTERN ###
################################
 */
  // INTERNER LINK
  elseif ($db_type[$dbf] == "intlink")
    {
    $input_item = "<br>&nbsp;<b>INTERNER Link (z.B. auf Produktseite)</b><br>";
    $input_item .= "<input type='text' size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    }

/*
################################
### LINK EXTERN ###
################################
 */
  // EXTERNER LINK
  elseif ($db_type[$dbf] == "extlink")
    {
    $input_item = "<br>&nbsp;<b>EXTERNER, vollst&auml;ndiger Link (z.B. zum Hersteller)</b><br>";
    $input_item .= "<input type='text' size='50' name='" . $db_fields[$dbf] . "' value='" . $current_entry . "'>&nbsp;";
    }

/*
################################
### DATUM ###
################################
 */
  // DATUM
  elseif (substr($db_type[$dbf],0,4) == "date")
    {
    // Wenn Update, Datum umwandeln. Ansonsten auf "0" setzen
    if ($current_entry >0)
      {
      $date_shown =  strftime("%d.%m.%Y", $current_entry);
      }
    elseif ($db_fields[$dbf] == $date_autofill)
      {
      $date_shown = date("d.m.Y");
      }
    else
      {
      $date_shown = "";
      }

    $calnr = substr($db_type[$dbf],4);
    $input_item = "<input type='text' size='15' name='" . $db_fields[$dbf] . "' value='" . $date_shown . "'>&nbsp;<a href='javascript:cal" . $calnr . ".popup();'><img src='images/cal.gif' width='16' height='16' border='0' alt='Klicken Sie hier um das Datum auszuw&auml;hlen'></a>";
    }

/*
################################
### DAUER ###
################################
 */
  // DURATION
  elseif ($db_type[$dbf] == "duration")
    {
    // Wenn Update, Datum umwandeln. Ansonsten auf "0" setzen
    if ($current_entry >0)
      {
      $this_reference = ${$db_fields[$dbf] . "_ref"};
      //echo "<br>ce: " . $current_entry;
      //echo "<br>tr: " . $$this_reference;
      $this_duration = $current_entry - $$this_reference;
      //echo $this_duration;
      $date_shown = showDuration($this_duration);
      }
    else
      {
      $date_shown = "";
      }


    $input_item = $date_shown;
    }

/*
################################
### SELECT ###
################################
 */
  // SELECT
  elseif (substr($db_type[$dbf],0,3) == "sel")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $input_item = "<select name='" . $db_fields[$dbf] . "'>";
    for ($loop=0; $loop<$this_count; $loop++)
      {
      $input_item .= "<option value='" . $this_array_values[$loop] . "'";
      if ($current_entry == $this_array_values[$loop])
        {
        $input_item .= " selected";
        }
      $input_item .= ">" . $this_array_labels[$loop] . "</option>";
      }
    $input_item .= "</select>";
    }

/*
################################
### SELECT VON ANDERER DATENBANK HERSTELLER ###
################################
 */
  // SELECT VON ANDERER DATENBANK HERSTELLER
  elseif (substr($db_type[$dbf],0,4) == "sex1")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $queried_field = substr($db_type[$dbf],5);
    //$this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $input_item = "<select name='" . $db_fields[$dbf] . "'>";

/*echo "produktgruppe: " . $produktgruppe . "<br>";
echo "queried_field: " . $queried_field . "<br>";
echo $helper_label . "<br>";
echo $helper_value . "<br>";
print_r($$helper_value) . "<br>";

echo "is this produktgruppe?: " . ${$queried_field};*/

    $input_item .= dropbox($table_used, $queried_field, ${$queried_field}, '');
    //echo $table_used . " - " . $db_fields[$dbf] . " - " . $this_array_values[$loop] . " - " . $first;

    $input_item .= "</select>";
    }

/*
################################
### CHECKBOXEN VON ANDERER DATENBANK ###
################################
 */
  // CHECKBOXEN VON ANDERER DATENBANK
  elseif (substr($db_type[$dbf],0,3) == "chx")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $helper_parent = $db_type[$dbf] . "_parent";
    $queried_field = substr($db_type[$dbf],4);
    //$this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $this_array_parent = $$helper_parent;
    //echo "<textarea>" . $this_array_labels . "</textarea>";
    //echo "<textarea>" . $this_array_values . "</textarea>";
    //echo "<textarea>" . $this_array_parent . "</textarea>";
    $input_item = "";

/*echo "produktgruppe: " . $produktgruppe . "<br>";
echo "queried_field: " . $queried_field . "<br>";
echo $helper_label . "<br>";
echo $helper_value . "<br>";
print_r($$helper_value) . "<br>";

echo "is this produktgruppe?: " . ${$queried_field};*/

    $input_item .= chxbox($table_seop, $queried_field, ${$this_array_parent}, $this_array_parent);

    //echo "<textarea>" . $$this_array_parent . "</textarea>";
    //echo "<textarea>" . chxbox($table_seop, $queried_field, ${$queried_field}, '') . "</textarea>";


    //echo $table_used . " - " . $db_fields[$dbf] . " - " . $this_array_values[$loop] . " - " . $first;

    //$input_item .= "</select>";
    }


/*
################################
### SELECT VON ANDERER DATENBANK PRODUKTGRUPPE DE ###
################################
 */
  // SELECT VON ANDERER DATENBANK PRODUKTGRUPPE DE
  elseif (substr($db_type[$dbf],0,4) == "sex2")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $input_item = "<select name='" . $db_fields[$dbf] . "'>";

    $input_item .= dropbox($table_selex_produktgruppen, 'produktgruppe', $produktgruppe, '');
    //echo $table_used . " - " . $db_fields[$dbf] . " - " . $this_array_values[$loop] . " - " . $first;

    $input_item .= "</select>";
    }


/*
################################
### SELECT MIT OPTIONBOX ###
################################
 */
  // SELECT mit OPTIONBOX
  elseif (substr($db_type[$dbf],0,4) == "seop")
    {
    //echo "SEOP!<br>";
    $helper_label = $db_type[$dbf] . "_label";
//echo "<br>helper-label: " . $helper_label . "<br>";
    $helper_value = $db_type[$dbf] . "_value";
    $current_label = $$helper_label;
    $current_value = $$helper_value;
    $this_count = count($current_label);
    $this_array_labels = $current_label;
    $this_array_values = $current_value;
    $input_item = "<select name='" . $db_fields[$dbf] . "'>";

    $field_queried = substr($db_type[$dbf],5);
    $current_field = $db_fields[$dbf];
    $current_entry = $$current_field;
    //echo "<br>+++" . $current_entry . "+++<br>";
    //echo "<br>+++" . $field_queried . "+++<br>";

    $input_item .= dropbox($table_seop, $field_queried, $current_entry, '');
    //echo $table_used . " - " . $db_fields[$dbf] . " - " . $this_array_values[$loop] . " - " . $first;

    $input_item .= "</select>";

    // addition new category
    $selname_helper = "new_" . $db_fields[$dbf];
    //$input_item .= "&nbsp;<input type='text' name='" . $selname_helper ."' value=''>&nbsp;<span class='small'>&lt;-wenn neu</span>";
    }

/*
################################
### RADIO ###
################################
 */
  // RADIOBOX
  elseif (substr($db_type[$dbf],0,3) == "rad")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $input_item = "";
    for ($loop=0; $loop<$this_count; $loop++)
      {
      $input_item .= "<input type='radio' name='" . $db_fields[$dbf] . "' value='" . $this_array_values[$loop] . "'";
      if (($current_entry == "" AND $db_type[$dbf] == "rad_aktiv" AND $loop == 0))
        {
        $input_item .= " checked";
        }
      elseif ($current_entry == $this_array_values[$loop])
        {
        $input_item .= " checked";
        }

      $input_item .= ">&nbsp;" . $this_array_labels[$loop] . "<br>";
      }
    }

/*
#################################
### RADIO FIRST ENTRY CHECKED ###
#################################
 */
  // RADIOBOX
  elseif (substr($db_type[$dbf],0,3) == "rac")
    {
    $helper_label = $db_type[$dbf] . "_label";
    $helper_value = $db_type[$dbf] . "_value";
    $this_count = count($$helper_label);
    $this_array_labels = $$helper_label;
    $this_array_values = $$helper_value;
    $input_item = "";
    for ($loop=0; $loop<$this_count; $loop++)
      {
      $input_item .= "<input type='radio' name='" . $db_fields[$dbf] . "' value='" . $this_array_values[$loop] . "'";
      if (($current_entry == "" AND $loop == 0))
        {
        $input_item .= " checked";
        }
      elseif ($current_entry == $this_array_values[$loop])
        {
        $input_item .= " checked";
        }

      $input_item .= ">&nbsp;" . $this_array_labels[$loop] . "<br>";
      }
    }

/*
################################
### CHECKBOX ###
################################
 */
  // CHECKBOX
  elseif (substr($db_type[$dbf],0,3) == "chk")
    {
    $this_array_labels = ${$db_type[$dbf] . "_label"};
    $this_array_values = ${$db_type[$dbf] . "_value"};
    @$this_count = count($this_array_labels);
    $input_item = "";

    $array_entries = explode('|', ${$db_fields[$dbf]});

    for ($loop=0; $loop<$this_count; $loop++)
      {
//echo "<br>this array values " . $this_array_values[$loop];

    $foo = $db_fields[$dbf] . $loop;
      $input_item .= "<div class='admin_chk'><input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $this_array_values[$loop] . "'";

      //if ($array_entries[$loop] == $this_array_values[$loop])
      foreach ($array_entries AS $cu)
        {
        //echo "cu: " . $cu . "<br>";
        if ($cu == $this_array_values[$loop])
          {
          $input_item .= " checked";
          }
        }
      $input_item .= ">&nbsp;" . $this_array_labels[$loop] . "</div>";
//echo "<textarea>" . $input_item . "</textarea>";
      }
    }

/*
################################
### CHECKBOX INLINE FLOAT ###
################################
 */
  // CHECKBOX Inline Float
  elseif (substr($db_type[$dbf],0,3) == "chf")
    {
    $this_array_labels = ${$db_type[$dbf] . "_label"};
    $this_array_values = ${$db_type[$dbf] . "_value"};
    @$this_count = count($this_array_labels);
    $input_item = "";

    $array_entries = explode('|', ${$db_fields[$dbf]});

    for ($loop=0; $loop<$this_count; $loop++)
      {
      $foo = $db_fields[$dbf] . $loop;
      $input_item .= "<div class='admin_chk halfwidth'><input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $this_array_values[$loop] . "'";

      //if ($array_entries[$loop] == $this_array_values[$loop])
      foreach ($array_entries AS $cu)
        {
        //echo "cu: " . $cu . "<br>";
        if ($cu == $this_array_values[$loop])
          {
          $input_item .= " checked";
          }
        }
      $input_item .= ">&nbsp;" . $this_array_labels[$loop] . "</div>";
      }
    }

/*
################################
### CHECKBOX RELATED ###
################################
 */
  // CHECKBOX RELATED
  elseif (substr($db_type[$dbf],0,3) == "rch")
    {
    $input_item = "";

    // Checked in DB
    $array_entries = explode('|', $current_entry);

//print_r($array_entries);

    // Neues Array mit IDs füllen
    $arr_checked_id = array();
    foreach ($array_entries AS $cu)
      {
      $cu_ex = explode("###", $cu);
      array_push($arr_checked_id, $cu_ex[0]);
      }

//print_r($arr_related);

    foreach ($arr_related AS $arr_relatedinfo)
      {
      $input_item .= "\n<input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $arr_relatedinfo[0] . "###" . $arr_relatedinfo[1] . "'";

    // Array mit Checked IDs und aktueller ID vergleichen
    if (in_array($arr_relatedinfo[0], $arr_checked_id))
      {
      $input_item .= " checked";
      }

      $input_item .= ">&nbsp;" . $arr_relatedinfo[1] . "<br>&nbsp;";
      }
    }

/*
################################
### TEXTAREA ###
################################
 */
  // TEXTAREA
  elseif ($db_type[$dbf] == "area")
    {
    $input_item = "\n\n<textarea name='" . $db_fields[$dbf] . "' xcols='82' xrows='10'>" . $current_entry . "</textarea>";
    }


/*
################################
### TEXTAREA PREFILLED ###
################################
 */
  // TEXTAREA PREFILLED
  elseif ($db_type[$dbf] == "pre_area")
    {
    if (${$db_fields[$dbf]} != "")
      {
      $pre_area = $current_entry;
      }
    else
      {
      $pre_area = ${$db_type[$dbf] . "_" . $db_fields[$dbf] . "_value"};
      }
    $input_item = "\n\n<textarea name='" . $db_fields[$dbf] . "' xcols='82' xrows='10'>" . $pre_area . "</textarea>";
    }

/*
################################
### HTML ###
################################
 */
  // HTML
  elseif ($db_type[$dbf] == "html")
    {
    $input_item = "<textarea class='htmlfield' id='" . $db_fields[$dbf] . "' name='" . $db_fields[$dbf] . "'>" . $current_entry . "</textarea>";

    $initializer .= "
    \n<script type=\"text/javascript\">
    $(function(){
    $('#" . $db_fields[$dbf] . "').htmlarea({css:'style//mine.css'})
    });
    </script>
    ";
    }

// ############# VIEW ONLY #############

  // VRAD
  elseif (substr($db_type[$dbf],0,4) == "vrad")
    {
    $helperl = "vrad_" . $db_fields[$dbf] . "_label";
    $this_arr = $$helperl;

    //print_r($foo) . "<br><br>";
    //echo "<br>???" . $foo[2] . "???<br><br>";

    //$helperl = $vrad_mitglied_label;

    //print_r($helperl) . "<br><br>";
    $input_item = "<span class='viewfield'>&nbsp;" . $this_arr[$current_entry] . "</span>";
    }

  // SHOW checked boxes
  elseif ($db_type[$dbf] == "schk")
    {//echo "#" . $current_entry . "#";
    if($current_entry != "")
      {
    $arr_current_entry = explode("|" , $current_entry);
    $input_item = "\n\n";
    $input_item .= "<ul class='checkmark'>";
    foreach($arr_current_entry AS $this_entry)
      {
      $input_item .= "<li>" . $this_entry . "</li>";
      }
    $input_item .= "</ul>";
      }
    }

  // YES/NO
  elseif ($db_type[$dbf] == "bool")
    {
    if($current_entry != "" AND $current_entry != "0")
      {
      $input_item = "<div class='xbool xboolyes'>JA</div>";
      }
    else
      {
      $input_item = "<div class='xbool xboolno'>NEIN</div>";
      }
    }

  // HIDDEN SORTORDER set to Gogol
  elseif ($db_type[$dbf] == "sortorder")
    {
    if(${$db_type[$dbf]} > 1)
    {
    $input_item = "<input type='hidden' name='" . $db_fields[$dbf] . "' value='" . ${$db_type[$dbf]} . "'>automatisch gesetzt";
    }
    else
    {
    $input_item = "<input type='hidden' name='" . $db_fields[$dbf] . "' value='999999'>automatisch gesetzt";
    }
//echo "<br>sortorder = " . ${$db_type[$dbf]} . "#";
    }

  // HIDDEN DATE
  elseif ($db_type[$dbf] == "hiddendate")
    {
    $input_item = "<input type='hidden' name='" . $db_fields[$dbf] . "' value='" . time() . "'>" . date("d.m.Y");
    }

  // YES/NO Sonderpatenschaft
  elseif ($db_type[$dbf] == "bool_sond")
    {
    if($current_entry != "" AND $current_entry != "0")
      {
      $input_item = "<div class='bool boolyes'>JA, " . $current_entry . "</div>";
      }
    else
      {
      $input_item = "<div class='bool boolno'>NEIN</div>";
      }
    }

  // CHECKBOX FARBEN
  elseif (substr($db_type[$dbf],0,3) == "fch")
    {
    // Datenbank öffnen
  ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Query
    $sql="SELECT * FROM $table_farben WHERE aktiv=1 ORDER BY sortorder ASC";
    $result=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Wieviele Einträge ?
    $number = mysqli_num_rows($result);

    // Wenn keine Einträge:
    if($number == 0)
      {
      print "Keine Einträge";
      }
    else
      {
      // Pro Datensatz wird eine Tabellenzeile geschrieben
      $arr_farben = array();
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
        //echo "* " . $handle . "-" . $farbname . "-" . $farbbezeichnung_de . "-" . $farb_hex . "<br>";
        array_push($arr_farben, array($handle, $farbname, $farbbezeichnung_de, $farb_hex));
        }
//echo "<br>Farben: #" . var_dump($arr_farben) . "#<br>";
      }

    $input_item = "";

    $array_entries = explode('|', $current_entry);

//var_dump($db_fields[$dbf]);
//echo "<br><br>";


    foreach ($arr_farben AS $arr_farbinfo)
      {

//echo "<br>Farbinfo: #" . var_dump($arr_farbinfo) . "#<br>";

      $input_item .= "<input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $arr_farbinfo[1] . "'";

      //if ($array_entries[$loop] == $this_array_values[$loop])
      foreach ($array_entries AS $cu)
        {
        if ($cu == $arr_farbinfo[1])
          {
          $input_item .= " checked";
          }
        }

      $input_item .= ">&nbsp;" . $arr_farbinfo[1] . " " . $arr_farbinfo[2] . "<br>";
      }
    }


  // CHECKBOX ZUBEHÖR
  elseif (substr($db_type[$dbf],0,3) == "zch")
    {
    // Datenbank öffnen
    ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Query
    $sql= "SELECT * FROM $table_zubehoer WHERE aktiv=1 ORDER BY sortorder ASC";
    $result=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Wieviele Einträge ?
    $number = mysqli_num_rows($result);

    // Wenn keine Einträge:
    if($number == 0)
      {
      print "Keine Einträge";
      }
    else
      {
      // Pro Datensatz wird eine Tabellenzeile geschrieben
      $arr_zubehoer = array();

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
        array_push($arr_zubehoer, array($handle, $name_de));
        }
      }

    $input_item = "";

    $array_entries = explode('|', $current_entry);

    foreach ($arr_zubehoer AS $arr_zubinfo)
      {
      $input_item .= "<div class='admin_chk_long'><input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $arr_zubinfo[0] . "'";

      //if ($array_entries[$loop] == $this_array_values[$loop])
      foreach ($array_entries AS $cu)
        {
        if ($cu == $arr_zubinfo[0])
          {
          $input_item .= " checked";
          }
        }

      $input_item .= ">&nbsp;" . $arr_zubinfo[1] . "</div>";
      }
    }

  // CHECKBOXEN DOWNLOADS (product_handle)
  elseif (substr($db_type[$dbf],0,3) == "dch")
    {
    // Datenbank öffnen
  ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Query
    $sql="SELECT DISTINCT produktname FROM $table_downloads WHERE aktiv=1 ORDER BY sortorder ASC";
    $result=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    // Wieviele Einträge ?
    $number = mysqli_num_rows($result);

    // Wenn keine Einträge:
    if($number == 0)
      {
      print "Keine Einträge";
      }
    else
      {
      // Pro Datensatz wird eine Tabellenzeile geschrieben
      $arr_farben = array();
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
        //echo "* " . $handle . "-" . $farbname . "-" . $farbbezeichnung_de . "-" . $farb_hex . "<br>";
        array_push($arr_farben, array($handle, $produktname, $farbbezeichnung_de, $farb_hex));
        }
//echo "<br>Farben: #" . var_dump($arr_farben) . "#<br>";
      }

    $input_item = "";

    $array_entries = explode('|', $current_entry);

//var_dump($db_fields[$dbf]);
//echo "<br><br>";


    foreach ($arr_farben AS $arr_farbinfo)
      {

//echo "<br>Farbinfo: #" . var_dump($arr_farbinfo) . "#<br>";

      $input_item .= "<input type='checkbox' name='" . $db_fields[$dbf] . "[]' value='" . $arr_farbinfo[1] . "'";

      //if ($array_entries[$loop] == $this_array_values[$loop])
      foreach ($array_entries AS $cu)
        {
        if ($cu == $arr_farbinfo[1])
          {
          $input_item .= " checked";
          }
        }

      $input_item .= ">&nbsp;" . $arr_farbinfo[1] . " " . $arr_farbinfo[2] . "<br>";
      }
    }

  // CHANGELINK / UPLINK für Dropzone
  elseif ($db_type[$dbf] == "changelink" OR $db_type[$dbf] == "uplink")
    {
    $input_item = "Links f&uuml;r Administration";
    }




  // UNBEKANNT
  else
    {
    $input_item = "\n\n<b>FEHLER !!!</b>";
    $input_item .= "<br>offender: " . $db_type[$dbf] . " (substr: " .  substr($db_type[$dbf],0,3) . ")";
    }

// Hidden fields
//$hiddenfields = "<input type='hidden' name='vergabedatum' value='" . $vergabedatum . "'>";


?>