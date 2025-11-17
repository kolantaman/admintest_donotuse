<?php
$arr_admin = array(
'Startdatum|date_start|date1|1',
'Enddatum|date_end|date2|1',
'Eventart|timeframe|rad_timeframe|0',
'Startzeit|time_start|text|1',
'Endzeit|time_end|text|1',
'Wiederholung Tag|repeatday|rad_repeatday|0',
'Eventttitel|title|text|1',
'Beschreibung|description|html|0',
'Datei|file|file|0',
'Location|location|pre_area|0',
'Aktiv|aktiv|rad_aktiv|1');

$table_used = 'events';
$id_proxy = 'id';
$bild_proxy = 'bild';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'date_start';
$default_sortdir = 'desc';
$date_autofill = 'date_start';
$this_prefix = 'Neuer ';
$this_topic_s = 'Eintrag';
$this_topic_p = 'Eintr&auml;ge';
$use_functions = '1';
$use_optionbox = '1';
$use_bigpicture = '0';
$use_calendar = '1';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end');
$images_width = '350';
$bigimages_width = '1000';
$bigimages_height = '800';
$hexbg = '#ffffff';
$downloadfolder = '';
$downloadfiles = '../downloads/events/';
$downloadimages = '../images/news/';
$downloadbigimages = '../images/news/big/';
$table_seop = 'location';
$block_newentry = '';
$block_delete = '';
$json_table = '';
$json_sortorder = '';
$json_path = '';
$json_filename = '';


$rad_timeframe_label = array('ganztags', 'unbekannt', 'von-bis:');
$rad_timeframe_value = array('1', '2', '3');

$rad_repeatday_label = array('t&auml;glich', 'SO', 'MO', 'DI', 'MI', 'DO', 'FR', 'SA', 'monatlich');
$rad_repeatday_value = array('0', '1', '2', '3', '4', '5', '6', '7', '8');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>