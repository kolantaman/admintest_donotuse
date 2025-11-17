<?php
$arr_admin = array(
'Startdatum|date_start|date1|1',
'Enddatum|date_end|date2|1',
'Online ab|date_online|date3|1',
'Offline ab|date_offline|date4|1',
'Headline de|headline_de|text|1',
'Text de|html_text_de|html|1',
'Headline en|headline_en|text|0',
'Text en|html_text_en|html|0',
'Headline cz|headline_cz|text|0',
'Text cz|html_text_cz|html|0',
'Headline sk|headline_sk|text|0',
'Text sk|html_text_sk|html|0',
'Bild 1|bild01|image|1',
'Bild 1 Titel de|bild01title_de|text|0',
'Bild 1 Titel en|bild01title_en|text|0',
'Bild 1 Titel cz|bild01title_cz|text|0',
'Bild 1 Titel sk|bild01title_sk|text|0',
'Bild 2|bild02|image|1',
'Bild 2 Titel de|bild02title_de|text|0',
'Bild 2 Titel en|bild02title_en|text|0',
'Bild 2 Titel cz|bild02title_cz|text|0',
'Bild 2 Titel sk|bild02title_sk|text|0',
'Bild 3|bild03|image|1',
'Bild 3 Titel de|bild03title_de|text|0',
'Bild 3 Titel en|bild03title_en|text|0',
'Bild 3 Titel cz|bild03title_cz|text|0',
'Bild 3 Titel sk|bild03title_sk|text|0',
'Datei|file_de|file|0',
'Videolink|videolink|vlink|0',
'Interner Link|intlink|intlink|0',
'Externer Link|extlink|extlink|0',
'Aktiv|aktiv|rad_aktiv|1');

$table_used = 'news';
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
$use_bigpicture = '1';
$use_calendar = '1';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end', 'date_online', 'date_offline');
$images_width = '350';
$bigimages_width = '1200';
$bigimages_height = 'auto';
$hexbg = '#333333';
$downloadfolder = '../downloads/news/';
$downloadfiles = '../downloads/news/';
$downloadimages = '../images/news/';
$downloadbigimages = '../images/news/big/';
$table_seop = 'mitarbeiter';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'landwirte';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_landwirte.json';


$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>