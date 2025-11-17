<?php
$arr_admin = array(
'Name|name|text|1',
'Bezeichnung|bezeichnung|text|1',
'Adresse|adresse|text|1',
'Ort|ort|text|1',
'Telefon|telefon|text|0',
'Telefax|telefax|text|0',
'E-Mail|email|text|0',
'Website|website|weblink|0',
'info|info|area|0',
'Logo|logo01|image|1',
'Aktiv|aktiv|rad_aktiv|1');

$table_used = 'aerzte';
$id_proxy = 'id';
$bild_proxy = 'logo';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neuer ';
$this_topic_s = 'Arzt';
$this_topic_p = '&Auml;rzte';
$use_functions = '1';
$use_optionbox = '0';
$use_bigpicture = '0';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end');
$images_width = '450';
$bigimages_width = '1000';
$bigimages_height = '800';
$hexbg = '#ffffff';
$downloadfolder = '';
$downloadfiles = '../downloads/events/';
$downloadimages = '../images/aerzte/';
$downloadbigimages = '../images/location/big/';
$table_seop = 'aerzte';
$block_newentry = '';
$block_delete = '';
$json_table = '';
$json_sortorder = '';
$json_path = '';
$json_filename = '';


$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>