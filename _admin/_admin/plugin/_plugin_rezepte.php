<?php
$arr_admin = array(
'Rezeptname|rezeptname|text|1',
'Rezeptname kurz|rezeptname_kurz|text|0',
'Kategorie|kategorie|sel_kategorie|1',
'Produkttags|produkttags|chx_produkt_tag|1',
'Rezept von|credit_rezept|text|0',
'Foto von|credit_foto|text|0',
'Zutaten|zutaten|area|0',
'Zubereitung|zubereitung|html|0',
'Foto|foto01|image|1',
'Aktiv|aktiv|rad_aktiv|1',
'Sortorder|sortorder|sortorder|1');

$table_used = 'rezepte';
$id_proxy = 'id';
$bild_proxy = 'foto';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neues ';
$this_topic_s = 'Rezept';
$this_topic_p = 'Rezepte';
$use_functions = '1';
$use_optionbox = '1';
$use_bigpicture = '1';
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
$table_seop = 'produkte';
$block_newentry = 'no';
$block_delete = 'no';
$json_table = 'rezepte';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_rezepte.json';


$sel_kategorie_label = array('Tofu', 'Seitan', 'Laibchen', 'Fertiggericht');
$sel_kategorie_value = array('tofu', 'seitan', 'laibchen', 'fertiggericht');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>