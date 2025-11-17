<?php
$arr_admin = array(
'Produkt|produkt|text|1',
'Produkt Langname|produkt_long|text|0',
'Produkt Tag|produkt_tag|text|0',
'Kategorie|kategorie|sel_kategorie|1',
'Zutaten|zutaten|html|0',
'Energie|energie|text|0',
'Fett|fett|text|0',
'Ges&auml;ttigt|gesaettigt|text|0',
'Kohlehydrate|kohlehydrate|text|0',
'Zucker|zucker|text|0',
'Ballast|ballast|text|0',
'Eiweiss|eiweiss|text|0',
'Salz|salz|text|0',
'Handelsmarken|handelsmarken|chk_handelsmarken|0',
'Packungsgr&ouml;ssen|packungsgroessen|chk_packungsgroessen|0',
'Lagerung gek&uuml;hlt|lagerung_gekuehlt|pre_area|0',
'Lagerung ungek&uuml;hlt|lagerung_ungekuehlt|area|0',
'Hergestellt|hergestellt|rad_hergestellt|0',
'K&uuml;hlung|kuehlung|chk_kuehlung|0',
'Foto|foto01|image|1',
'Aktiv|aktiv|rad_aktiv|1',
'Sortorder|sortorder|sortorder|1');

$table_used = 'produkte';
$id_proxy = 'id';
$bild_proxy = 'foto';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neues ';
$this_topic_s = 'Produkt';
$this_topic_p = 'Produkte';
$use_functions = '1';
$use_optionbox = '0';
$use_bigpicture = '1';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end');
$images_width = '640';
$bigimages_width = '909';
$bigimages_height = 'auto';
$hexbg = '#ffffff';
$downloadfolder = '../downloads/news/';
$downloadfiles = '../downloads/';
$downloadimages = '../images/produkte/';
$downloadbigimages = '../images/produkte/big/';
$table_seop = 'produkte';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'produkte';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_produkte.json';


$sel_kategorie_label = array('Tofu', 'Seitan', 'Laibchen', 'Fertiggericht');
$sel_kategorie_value = array('tofu', 'seitan', 'laibchen', 'fertiggericht');

$chk_handelsmarken_label = array('Sojarei', 'Feel Good', 'Vegavita');
$chk_handelsmarken_value = array('Sojarei', 'Feelgood', 'Vegavita');

$chk_packungsgroessen_label = array('135g', '150g', '200g', '230g', '250g', '500g', '1000g', '3000g', '2x80g', '2x100g', '2x115g', '2x125g');
$chk_packungsgroessen_value = array('135g', '150g', '200g', '230g', '250g', '500g', '1000g', '3000g', '2x80g', '2x100g', '2x115g', '2x125g');

$rad_hergestellt_label = array('Hergestellt in Nieder&ouml;sterreich', 'Hergestellt in Nieder&ouml;sterreich mit Bio-Sojabohnen <b>aus &Ouml;sterreich</b>');
$rad_hergestellt_value = array('1', '2');

$chk_kuehlung_label = array('gek&uuml;hlt', 'ungek&uuml;hlt');
$chk_kuehlung_value = array('gekuehlt', 'ungekuehlt');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>