<?php
$arr_admin = array(
'handle|handle|text|0',
'Dach/Wand|dach_wand|chk_dach_wand|1',
'Produktgruppe|produktgruppe|rad_produktgruppe|1',
'Profilname de|profilname_de|text|1',
'Profilname en|profilname_en|text|0',
'Profilname cz|profilname_cz|text|0',
'Profilname sk|profilname_sk|text|0',
'Blechstaerken|blechstaerken|chk_blechstaerken|0',
'Gewicht|gewicht|chk_gewicht|0',
'Baubreite|baubreite|text|0',
'Farben|farben|fch_farben|0',
'Startfarbe|firstcolor|text|0',
'Pos/Neg|posneg|chk_posneg|0',
'Antikondens|antikondens|rad_antikondens|0',
'Lichtplatten|lichtplatten|rad_lichtplatten|0',
'Laenge_min|laenge_min|int|0',
'Laenge_max|laenge_max|int|0',
'Zubehoer|zubehoer|zch_zubehoer|0',
'Produktinfo de|produktinfo_de|area|0',
'Produktinfo en|produktinfo_en|area|0',
'Produktinfo cz|produktinfo_cz|area|0',
'Produktinfo sk|produktinfo_sk|area|0',
'Aktiv|aktiv|rad_aktiv|1');

$table_used = 'profile';
$id_proxy = 'id';
$bild_proxy = 'bild';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neuer ';
$this_topic_s = 'Eintrag';
$this_topic_p = 'Eintr&auml;ge';
$use_functions = '1';
$use_optionbox = '0';
$use_bigpicture = '0';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start');
$images_width = '350';
$bigimages_width = '1000';
$bigimages_height = '800';
$hexbg = '#ffffff';
$downloadfolder = '../downloads/news/';
$downloadfiles = '../downloads/events/';
$downloadimages = '../images/news/';
$downloadbigimages = '../images/news/big/';
$table_seop = 'location';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'produkte';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_production.json';


$chk_dach_wand_label = array('Dach', 'Wand');
$chk_dach_wand_value = array('dach', 'wand');

$rad_produktgruppe_label = array('Trapezprofil', 'Dachpfanne', 'Wellblech', 'anderes');
$rad_produktgruppe_value = array('trapezprofil', 'dachpfanne', 'wellblech', '');

$chk_blechstaerken_label = array('0,50', '0,60', '0,63', '0,75', '0,88', '1,00', '1,25');
$chk_blechstaerken_value = array('0,50', '0,60', '0,63', '0,75', '0,88', '1,00', '1,25');

$chk_gewicht_label = array('0,048', '0,056', '0,057', '0,059', '0,060', '0,061', '0,067', '0,071', '0,072', '0,073', '0,080', '0,083', '0,084', '0,085', '0,086', '0,094', '0,096', '0,098', '0,106', '0,107', '0,121', '0,126', '0,134', '0,142', '0,143', '0,161', '0,179', '0,201');
$chk_gewicht_value = array('0,048', '0,056', '0,057', '0,059', '0,060', '0,061', '0,067', '0,071', '0,072', '0,073', '0,080', '0,083', '0,084', '0,085', '0,086', '0,094', '0,096', '0,098', '0,106', '0,107', '0,121', '0,126', '0,134', '0,142', '0,143', '0,161', '0,179', '0,201');

$chk_posneg_label = array('Positiv', 'Negativ');
$chk_posneg_value = array('positiv', 'negativ');

$rad_antikondens_label = array('Ja', 'Nein');
$rad_antikondens_value = array('1', '0');

$rad_lichtplatten_label = array('Ja', 'Nein');
$rad_lichtplatten_value = array('1', '0');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>