<?php
$arr_admin = array(
'Startdatum|date_start|date1|1',
'Enddatum|date_end|date2|1',
'Offline ab|date_offline|date3|1',
'Headline|headline_de|text|1',
'Text|html_text_de|html|1',
'Bild 1|bild01|image|1',
'Bild 1 Titel|bild01title_de|text|0',
'Bild 2|bild02|image|1',
'Bild 2 Titel|bild02title_de|text|0',
'Bild 3|bild03|image|1',
'Bild 3 Titel|bild03title_de|text|0',
'Datei|file|file|0',
'Videolink|videolink|vlink|0',
'Interner Link|intlink|intlink|0',
'Externer Link|extlink|extlink|0',
'Aktiv|aktiv|rad_aktiv|1');

$table_used = 'news';
$id_proxy = 'id';
$bild_proxy = 'bild';
$file_proxy = 'file';
$sortorder_proxy = '';
$default_order = 'date_start';
$default_sortdir = 'desc';
$date_autofill = 'date_start';
$this_prefix = 'Neuer ';
$this_topic_s = 'Eintrag';
$this_topic_p = 'Eintr&auml;ge';
$use_functions = '1';
$use_optionbox = '1';
$use_bigpicture = '1';
$use_calendar = '1';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end', 'date_offline');
$images_width = '450';
$bigimages_width = '1200';
$bigimages_height = '800';
$hexbg = '#333333';
$downloadfolder = '../downloads/news/';
$downloadfiles = '../downloads/';
$downloadimages = '../images/news/';
$downloadbigimages = '../images/news/big/';
$table_seop = '';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'news';
$json_sortorder = 'date_start';
$json_path = '../_includes/';
$json_filename = '_news.json';


$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>