<?php
$arr_admin = array(
'Name|snipname|text|1',
'Handle|sniphandle|text|1',
'Kategorie|kategorie|sel_kategorie|1',
'Code|snipcode|area|0',
'Aktiv|aktiv|rad_aktiv|1',
'Sortorder|sortorder|sortorder|1');

$table_used = 'snippets';
$id_proxy = 'id';
$bild_proxy = 'foto';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neues ';
$this_topic_s = 'Snippet';
$this_topic_p = 'Snippets';
$use_functions = '1';
$use_optionbox = '1';
$use_bigpicture = '0';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end');
$images_width = '640';
$bigimages_width = '1200';
$bigimages_height = 'auto';
$hexbg = '#ffffff';
$downloadfolder = '../downloads/news/';
$downloadfiles = '../downloads/';
$downloadimages = '../images/rezepte/';
$downloadbigimages = '../images/rezepte/big/';
$table_seop = 'snippets';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'snippets';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_rezepte.json';


$sel_kategorie_label = array('Bootstrap', 'MySQLi', 'CSS', 'HTML/PHP', 'Stuff');
$sel_kategorie_value = array('Bootstrap', 'Mysqli', 'CSS', 'HTML/PHP', 'Stuff');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>