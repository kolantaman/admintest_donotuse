<!DOCTYPE html>

<html>

<head>
  <title>Plugin Converter Tool</title>
<link rel="stylesheet" type="text/css" href="../../css/custom.css">
<style type="text/css">
<!--
.convertlist LI
  {
  max-width: 30rem;
  background: #fff;
  border: 1px solid gray;
  border-radius: 0.25rem;
  padding: 0.25rem 0.5rem;
  margin: 0.25rem;
  }

-->
</style>
</head>

<body>
  <h1>Mighty Plugin Converter</h1>
<?php
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(E_ALL);
//echo "start<br>";
require("../_functions.php");


//$my_dir = "../../../__blank/_admin/plugin/";
$my_dir = "old\\";
$writedir = "new\\";
$copyright = "// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.\n// created: " . date('ymd');
$found_plugins = array();

echo "Current directory: " . realpath($my_dir) . "<br>";
echo "Writing to: " . realpath($my_dir) . "\\" . $writedir . "<br>";

// Sort in ascending order - this is default
$files = scandir(realpath($my_dir));
foreach($files AS $candidate)
  {
  if(substr($candidate,0,7) == "_plugin")
    {
    array_push($found_plugins, $candidate);
    //echo "<br>#" . substr($candidate,0,7) . "#";
    }

  unset($files);
  }
echo count($found_plugins) . " plugins found.<br>";
//var_dump($files);

echo "<h2>Converting:</h2>";
echo "<ul class='convertlist'>";
// loop for every plugin found
foreach($found_plugins AS $convert_plugin)
  {
  // function returns all variables inplugin only as $vars
  $vars = getpluginvars($my_dir . $convert_plugin);

  // include plugin into global namespace
  include($my_dir . $convert_plugin);

  // get defined variables from plugin
  $ignore = array('GLOBALS', '_FILES', '_COOKIE', '_POST', '_GET', '_SERVER', '_ENV', '_REQUEST', 'ignore', 'found_plugins', 'vars', 'fixedparam', 'parametry', 'value', 'my_dir', 'key', 'path', 'content', 'candidate', 'convert_plugin', 'fieldcount', 'arr_admin', 'fc', 'output', 'outliers', 'outnumber', 'dbt', 'this_label', 'this_value', 'downloadfolder_de', 'downloadfolder_en', 'admin_marker', 'pop_sql');
  // diff the ignore list as keys after merging any missing ones with the defined list
  //$vars = array_diff_key(get_defined_vars() + array_flip($ignore), array_flip($ignore));
  // should be left with the user defined var(s) (in this case $testVar)


  // fixed types of fields - known $show_type / $db_type to be filtered out = get custom arrays
  $fixedparam = array("text", "string", "area", "html", "datum", "date1", "date2", "date3", "image", "file", "intlink", "extlink", "vlink", "weblink", "db_fields", "show_admin", "db_labels", "db_type", "show_label", "show_type", "show_admin_count", "sortorder", "sort_sortorder", "int");

  // fixed variables in any plugin
  $parametry = array(
  "table_used",
  "id_proxy",
  "bild_proxy",
  "file_proxy",
  "sortorder_proxy",
  "default_order",
  "default_sortdir",
  "date_autofill",
  "this_prefix",
  "this_topic_s",
  "this_topic_p",
  "use_functions",
  "use_optionbox",
  "use_bigpicture",
  "use_calendar",
  "use_doubledigit",
  "names_calendars",
  "images_width",
  "bigimages_width",
  "bigimages_height",
  "hexbg",
  "downloadfolder",
  "downloadfiles",
  "downloadimages",
  "downloadbigimages",
  "table_seop",
  "block_newentry",
  "block_delete",
  "json_table",
  "json_sortorder",
  "json_path",
  "json_filename");

echo "<li>" . $convert_plugin . " (" . count(($vars['db_fields'])) . " fields)</li>";
//echo "<br>" . count(($vars['db_fields'])) . " - " . $convert_plugin;

  // ### creating $arr_admin, containig all field information ###
  $fieldcount = count($vars['db_fields']);
  $arr_admin = '$arr_admin = array(';

  for($fc=0;$fc<$fieldcount;$fc++)
    {
  $dblabels = $vars['db_labels'];
  $dbfields = $vars['db_fields'];
  $dbtype = $vars['db_type'];

  $dbcheck = $vars['db_fields'];
  //echo "<br>: " . $dbcheck[$fc];
  //echo "<br>: " . $vars['show_admin'];

  //echo "<br>### dbcheck-fc: " . $dbcheck[$fc] . "<br>";

  if (in_array($dbcheck[$fc], $vars['show_admin']))
    {
    $admin_marker = "1";
    }
  else
    {
    $admin_marker = "0";
    }
    $arr_admin .= "\n'" . $dblabels[$fc] . "|" . $dbfields[$fc] . "|" . $dbtype[$fc] . "|" . $admin_marker . "',";
    //echo "<br>cf: " . $current_field;
    }

  $arr_admin .= ");";
  $arr_admin = str_replace(",)", ")", $arr_admin);
// ### creating $arr_admin, containig all field information EOF ###


//  ############  FIXED VARIABLES  #############
$output = "";
foreach($parametry AS $parameter)
  {
  $parameter_value = $$parameter;

  if(is_array($parameter_value))
    {
    $output .= "$" . $parameter . " = array(";
    foreach($parameter_value AS $val)
      {
      $output .= "'" . $val . "', ";
      }
    $output .= ");\n";
    $output = str_replace("', )", "')", $output);
    }
  else
    {
    $output .= "$" . $parameter . " = '" . $parameter_value . "';\n";
    }
  }
//  ############  FIXED VARIABLES  EOF #############


//  ############  OUTLIER VARIABLES  #############
$arr_outliers = array();

$dblabels = $vars['db_labels'];
$dbfields = $vars['db_fields'];
$dbtype = $vars['db_type'];
//var_dump($fixedparam);
//var_dump($parametry);
//var_dump($dbtype);
foreach($dbtype As $dbt)
  {
  // checking vars contained in plugin aggainst fieldparams
  if (!in_array($dbt, $fixedparam) AND !in_array($dbt, $parametry))
    {
    array_push($arr_outliers, $dbt);
    }
    // $arr_outliers contains list of vars to write
    //var_dump($arr_outliers);

    $outliers = "";

    foreach($arr_outliers AS $one_outlier)
      {
      $one_outlier_value = ${$one_outlier . "_value"};
      $one_outlier_label = ${$one_outlier . "_label"};
      //echo "<br>value " . $one_outlier . ": x" . $one_outlier_value . "x<br>";
      if($one_outlier_value != "")
        {
        if(is_array($one_outlier_value))
          {
          $outliers .= "$" . $one_outlier . "_label = array(";
          foreach($one_outlier_label AS $val)
            {
            $outliers .= "'" . $val . "', ";
            }
          $outliers .= ");\n";
          $outliers = str_replace("', )", "')", $outliers);

          $outliers .= "$" . $one_outlier . "_value = array(";
          foreach($one_outlier_value AS $val)
            {
            $outliers .= "'" . $val . "', ";
            }
          $outliers .= ");\n\n";
          $outliers = str_replace("', )", "')", $outliers);
          }
        else
          {
          $outliers .= "$" . $one_outlier . " = '" . $one_outlier_value . "';\n";
          }
       }
      }
  }
//  ############  OUTLIER VARIABLES EOF  #############


// path to new file(s)
//$path = $my_dir . $writedir . $convert_plugin;
$path = $writedir . $convert_plugin;
//echo "<br>" . realpath($path);
//echo "<br>length: " . strlen($content);

// write new plugincode to file
$foo =  writeFile($path, "<?php\n" . $arr_admin . "\n\n" . $output . "\n\n" . $outliers . $copyright . "\n?>");

unset($foo);
unset($convert_plugin);
  }  // eof foreach $convert_plugin
echo "</ul>";
// functions
function getpluginvars($file)
  {
  require_once($file);
  unset($pop_sql);
// get defined variables from plugin
$ignore = array('GLOBALS', '_FILES', '_COOKIE', '_POST', '_GET', '_SERVER', '_ENV', '_REQUEST', 'ignore', 'found_plugins', 'vars', 'fixedparam', 'parametry', 'value', 'my_dir', 'key', 'path', 'content', 'candidate', 'convert_plugin', 'fieldcount', 'arr_admin', 'fc', 'output', 'outliers', 'outnumber', 'dbt', 'this_label', 'this_value', 'downloadfolder_de', 'downloadfolder_en', 'admin_marker', 'pop_sql');
// diff the ignore list as keys after merging any missing ones with the defined list
$vars = array_diff_key(get_defined_vars() + array_flip($ignore), array_flip($ignore));
return $vars;
  }
?>
</body>
</html>