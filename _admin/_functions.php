<?php
function ConvertFilename($text)
  {
  // Nicht erlaubte Zeichen umwandeln


  $text_from = array();
  $text_to = array();

  // first wave
  array_push($text_from,"ä","Ä", "ö", "Ö", "ü", "Ü", "ß", "(", ")", " ");

  array_push($text_to,"ae","ae", "oe", "oe", "ue", "ue", "ss", "", "", "_");

  $replacements = count($text_from);
  //echo "Replacements: " . $replacements . "<br>";
  for ( $cu = 0; $cu < $replacements; $cu++ )
    {
      //echo "<br>from: " . $text_from[$cu] . " to " . $text_to[$cu];
    $text = str_replace ( $text_from[$cu], $text_to[$cu], $text );
    }
 return strtolower($text);
  }


function ConvertUmlauts2($text)
  {
  // Nicht erlaubte Zeichen umwandeln


  $text_from = array();
  $text_to = array();

  // first wave
  array_push($text_from,"&","ä", "ö", "ü", "Ä", "Ö", "Ü", "ß", "™", "²", "„", "”", "“", "´", "°", "®", "é", "ñ", "ž", "á", "€", "§");

  array_push($text_to,"&amp;","&auml;", "&ouml;", "&uuml;", "&Auml;", "&Ouml;", "&Uuml;", "&szlig;", "&trade;", "&sup2;", "&acute;", "&acute;", "&acute;", "&acute;", "&deg;", "&reg;", "&eacute;", "&ntilde;", "&#0158;", "&aacute;", "&euro;", "&sect;");

  // czech characters
  array_push($text_from,"Á","á","Ą","ą","É","é","Ę","ę","Ě","ě","Í","í","Ó","ó","Ô","ô","Ú","ú","Ů","ů","Ý","ý","Č","č","ď","ť","Ĺ","ĺ","Ň","ň","Ŕ","ŕ","Ř","ř","Š","š","Ž","ž");

  array_push($text_to,"&Aacute;","&aacute;","&#x104;","&#x105;","&Eacute;","&eacute;","&#x118;","&#x119;","&#x11a;","&#283;","&Iacute;","&Iacute;","&Oacute;","&oacute;","&Ocirc;","&ocirc;","&Uacute;","&uacute;","&#x16e;","&#x16f;","&Yacute;","&yacute;","&#x10c;","&#x10d;","&#x10f;","&#x165;","&#x139;","&#x13a;","&#x147;","&#x148;","&#x154;","&#x155;","&#x158;","&#x159;","&#x160;","&#x161;","&#x17d;","&#x17e;");


  $replacements = count($text_from);
  //echo "Replacements: " . $replacements . "<br>";
  for ( $cu = 0; $cu < $replacements; $cu++ )
    {
      //echo "<br>from: " . $text_from[$cu] . " to " . $text_to[$cu];
    $text = str_replace ( $text_from[$cu], $text_to[$cu], $text );
    }
 return $text;
  }


function xConvertUmlauts($text)
  {
  return $text;
  }



function ConvertUmlauts($text)
  {
  // Nicht erlaubte Zeichen umwandeln


  $text_from = array();
  $text_to = array();

  // UTF-8 chars
  array_push($text_from, "Š", "Œ", "Ž", "š", "œ", "ž", "Ÿ", "¥", "µ", "À", "Á","Â","Ã","Ä","Å","Æ","Ç","È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "ß", "à", "á", "â" ,"ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "ÿ", "„", "”", "“", "–", "’");

  array_push($text_to, "&Scaron;", "&OElig;", "Ž", "&scaron;", "&oelig;", "ž", "&Yuml;", "&yen;", "&micro;", "&Agrave;", "&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&ETH;", "&Ntilde;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Oslash;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&Yacute;", "&szlig;", "&agrave;", "&aacute;", "&acirc;" ,"&atilde;", "&auml;", "&aring;", "&aelig;", "&ccedil;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&eth;", "&ntilde;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&oslash;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;", "&yacute;", "&yuml;", "&bdquo;", "&rdquo;", "&ldquo;", "&ndash;", "&#8217;");


  // first wave
  array_push($text_from,"&nbsp;", "ä", "ö", "ü", "Ä", "Ö", "Ü", "ß", "™", "²", "´", "°", "®", "é", "ñ", "ž", "á", "€", "§");

  array_push($text_to," ", "&auml;", "&ouml;", "&uuml;", "&Auml;", "&Ouml;", "&Uuml;", "&szlig;", "&trade;", "&sup2;", "&acute;", "&deg;", "&reg;", "&eacute;", "&ntilde;", "&#0158;", "&aacute;", "&euro;", "&sect;");

  // czech characters
  array_push($text_from,"Á","á","Ą","ą","É","é","Ę","ę","Ě","ě","Í","í","Ó","ó","Ô","ô","Ú","ú","Ů","ů","Ý","ý","Č","č","ď","ť","Ĺ","ĺ","Ň","ň","Ŕ","ŕ","Ř","ř","Š","š","Ž","ž", "ľ");

  array_push($text_to,"&Aacute;","&aacute;","&#x104;","&#x105;","&Eacute;","&eacute;","&#x118;","&#x119;","&#x11a;","&#283;","&Iacute;","&Iacute;","&Oacute;","&oacute;","&Ocirc;","&ocirc;","&Uacute;","&uacute;","&#x16e;","&#x16f;","&Yacute;","&yacute;","&#x10c;","&#x10d;","&#x10f;","&#x165;","&#x139;","&#x13a;","&#x147;","&#x148;","&#x154;","&#x155;","&#x158;","&#x159;","&#x160;","&#x161;","&#x17d;","&#x17e;", "&#x13e;");

// Editor Artifacts
  //array_push($text_from,'<span style="font-size: 14.44px;">', '</span>', '', '', '<p><br></p>', '<ul>');

  //array_push($text_to,'', '', '', '', '', '<ul class="prettylist">');

  array_push($text_from,'"font-size: 14.44px;"');

  array_push($text_to,'');

/*
  // TEST
  array_push($text_from,"ä", "ö", "ü", "Ä", "Ö", "Ü", "ß");
  array_push($text_to,"&auml;", "&ouml;", "&uuml;", "&Auml;", "&Ouml;", "&Uuml;", "&szlig;");
*/

  $replacements = count($text_from);
  //echo "Replacements: " . $replacements . "<br>";
  for ( $cu = 0; $cu < $replacements; $cu++ )
    {
    //echo "<br>from: " . $text_from[$cu] . " to " . $text_to[$cu];
    $text = str_replace ( $text_from[$cu], $text_to[$cu], $text );


    }
 //echo "<br><br>### " . $text . " ###<br><br><br>";
 return $text;
  }


function decode_special($string)
  {
  // Verwandelt codierte Sonderzeichen zurück
  $text_from = array();
  $text_to = array();

  // Convert from
  array_push($text_from, "#shy#");

  // Convert to
  array_push($text_to, "&shy;");

  $replacements = count($text_from);
  //echo "Replacements: " . $replacements . "<br>";
  for ( $cu = 0; $cu < $replacements; $cu++ )
    {
    $text = str_replace ( $text_from[$cu], $text_to[$cu], $string );
    }
 return $text;
  }


function NumberFormat($number)
  {
  if($number == 0 OR $number == "")
    {
    $ret = number_format(0,2,",",".");
    }
  else
    {
    $ret = number_format($number,2,",",".");
    }
  return $ret;
  }


function HexToRGB ($color)
  {
  //str_replace ('#', '*', $color );
  $color = substr($color, -6);
  $c1 = substr($color, 0, 2);
  $c2 = substr($color, 2, 2);
  $c3 = substr($color, -2);
  $arr_rgbcolors = array(hexdec($c1),hexdec($c2),hexdec($c3));
  return $arr_rgbcolors;
  }

function Sanitize($text)
  {
  // Nicht erlaubte Zeichen umwandeln
  $text_from = array(chr(34), chr(147), chr(148), chr(39), chr(59), chr(40), chr(41), chr(91), chr(93), chr(123), chr(125), chr(42), "'", '"', ";");
  $replacements = count($text_from);
  for ( $cu = 0; $cu < $replacements; $cu++ )
    {
    //$text = str_replace ( $text_from[$cu], "", $text );
    }
 return $text;
  }

function asciimail_full($mailstring)
  {
  $asciimail = "";
  $len = strlen($mailstring);
  for ($l=0;$l<$len;$l++)
    {
    $asciimail = $asciimail .  "&#" . ord(substr($mailstring,$l,1)) . ";";
    }
  $full_address = "<a href='mailto:" . $asciimail . "'>" . $asciimail . "</a>";
  return $full_address;
  }

function sessionme($varname, $value)
  {
  $_SESSION["$varname"] = "$value";
  }


// Text List to HTML List
function nl2li($str,$ordered = 0, $type = "1") {

//check if its ordered or unordered list, set tag accordingly
if ($ordered)
{
  $tag="ol";
  //specify the type
  $tag_type="type=$type";
}
else
{
  $tag="ul";
  //set $type as NULL
  $tag_type=NULL;
}

// add ul / ol tag
// add tag type
// add first list item starting tag
// add last list item ending tag
$str = "<$tag $tag_type><li>" . $str ."</li></$tag>";

//replace /n with adding two tags
// add previous list item ending tag
// add next list item starting tag
$str = str_replace("\n","</li>\n<li>",$str);

//spit back the modified string
return $str;
}

// Get MySQLi data
function mysqli_fetch_data($host, $database, $username, $password, $table, $condition, $order)
{
($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$sql = "SELECT * FROM $table $condition $order";
//echo $sql . "<br>";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Wieviele Einträge ?
$number = mysqli_num_rows($result);
//echo "Total Number: " . $number . "<br><br>";

// Wenn keine Einträge:
if($number == 0)
  {
  //echo "keine Einträge";
  }
// Ansonsten auflisten
else
  {
  $arr_return = array();

  // Datensatz durchlaufen
  for ($i = 0; $i < $number; $i++)
    {
    // Variable entsprechend den Feldnamen werden erstellt
    $current = mysqli_fetch_assoc($result);
    $fields = count($current);
    //echo "<br>Number: " . $i . "<br>";
    //print_r($current) . "<br>#";
    array_push($arr_return, $current);
    }

  //echo $number;
  return $arr_return;
  }
  mysqli_close("___mysqli_ston");
}

// MYSQL TO MYSQLi Converter
// http://localhost/_mysqli/GUI/convert_file.php
// function needed

function mysqli_result($result, $number, $field=0)
  {
  mysqli_data_seek($result, $number);
  $type = is_numeric($field) ? MYSQLI_NUM : MYSQLI_ASSOC;
  $out = mysqli_fetch_array($result, $type);
  if ($out === NULL || $out === FALSE || (!isset($out[$field])))
    {
    return FALSE;
    }
  return $out[$field];
  }

// Write string to file
// Path: Full path including filename
// Content: String that is written to that file
// Mode: Add to file if empty, Replace file if "append"
function writeFile($path, $content, $mode="replace")
  {
  if($mode != "replace")
    {
    file_put_contents($path, $content, FILE_APPEND);
    }
  else
    {
    file_put_contents($path, $content);
    }
  }

// Read file
// Path: Full path including filename
function readMyFile($path)
  {
  $filecontent = file_get_contents($path);
  return $filecontent;
  }

function removeUnwantedTagsAndClasses($html) {
    if (strpos($html, '<html') !== false) {
        $cleanedHtml = preg_replace('/<body[^>]*>(.*?)<\/body>/is', '$1', $html);
        if ($cleanedHtml === null) {
            $cleanedHtml = $html;
        }
    } else {
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html); // Add XML encoding declaration

        $tagsToRemove = ['span', 'font'];
        foreach ($tagsToRemove as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            for ($i = $elements->length - 1; $i >= 0; $i--) {
                $element = $elements->item($i);
                if ($element && $element->parentNode) {
                    while ($element->hasChildNodes()) {
                        $element->parentNode->insertBefore($element->firstChild, $element);
                    }
                    $element->parentNode->removeChild($element);
                }
            }
        }

        $tagsToClean = ['p', 'div'];
        foreach ($tagsToClean as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            for ($i = $elements->length - 1; $i >= 0; $i--) {
                $element = $elements->item($i);
                if ($element) {
                    while ($element->attributes->length > 0) {
                        $element->removeAttribute($element->attributes->item(0)->nodeName);
                    }
                }
            }
        }

        // Correct way to get the cleaned HTML *without* losing structure:
        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body) {
            $cleanedHtml = '';
            foreach ($body->childNodes as $node) {
                $cleanedHtml .= $dom->saveHTML($node);
            }
        } else {
            $cleanedHtml = ''; // Handle cases where body is not found
        }
    }

    return $cleanedHtml;
}
?>