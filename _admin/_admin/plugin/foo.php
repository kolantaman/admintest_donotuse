<?php
error_reporting(E_ALL);
echo "this is foo<br>";
foreach($found_plugins AS $convert_plugin)
  {
  $vars = getpluginvars($my_dir . $convert_plugin);
  include($my_dir . $convert_plugin);
  //echo "<br>nc: " . $names_calendars;
  if(is_array($names_calendars))
    {
    //echo "<br>YES, it's an array!";
    }
  //print_r($vars) . "<br>";

  //echo "<br>dbfields: " . $vars['date_autofill'] . "<br>";

  //var_dump($vars);

// get defined variables from plugin
$ignore = array('GLOBALS', '_FILES', '_COOKIE', '_POST', '_GET', '_SERVER', '_ENV', '_REQUEST', 'ignore', 'found_plugins', 'vars', 'fixedparam', 'parametry', 'value', 'my_dir', 'key', 'path', 'content', 'candidate', 'convert_plugin', 'fieldcount', 'arr_admin', 'fc', 'output', 'outliers', 'outnumber', 'dbt', 'this_label', 'this_value', 'downloadfolder_de', 'downloadfolder_en', 'admin_marker', 'pop_sql');
// diff the ignore list as keys after merging any missing ones with the defined list
//$vars = array_diff_key(get_defined_vars() + array_flip($ignore), array_flip($ignore));
// should be left with the user defined var(s) (in this case $testVar)
//var_dump($vars);


// fixed parameters - known $show_type / $db_type to be filtered out = get custom arrays
$fixedparam = array("text", "string", "area", "html", "datum", "date1", "date2", "date3", "image", "file", "intlink", "extlink", "vlink", "weblink", "db_fields", "show_admin", "db_labels", "db_type", "show_label", "show_type", "show_admin_count", "sortorder", "sort_sortorder");

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

$output = "";

//  ############  FIXED VARIABLES  #############
foreach($parametry AS $parameter)
  {
  //echo "<br>** " . $parameter . " = " . ${$parameter};
  //$fieldvalue = checkset($$parameter);
  $parameter_value = $$parameter;

  if(is_array($parameter_value))
    {
    $output .= $parameter . " = array(";
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
echo "ok";


//echo $output;



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
  //echo "<br>DBT: " . $dbt;
  //echo "this is: " . $dbt . " and it's value is: " .  $$dbt . "<br>";
  if (!in_array($dbt, $fixedparam) AND !in_array($dbt, $parametry))
    {
    //echo "<br><b>SHOT " . $dbt . "</b><br>";
    array_push($arr_outliers, $dbt);
    }
    var_dump($arr_outliers);

//  ############  OUTLIER VARIABLES EOF  #############


$path = $my_dir . "new/" . $convert_plugin;
//echo "<br>" . $path;
//echo "<br>length: " . strlen($content);
$foo =  writeFile($path, $arr_admin . "\n\n" . $output . "\n\n" . $outliers);

unset($foo);
unset($convert_plugin);
}
  }  // eof foreach $convert_plugin

?>