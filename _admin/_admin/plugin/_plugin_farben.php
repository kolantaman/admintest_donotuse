<?php
$arr_admin = array(
'Handle|handle|text|0',
'Farbname|farbname|text|1',
'Farbbezeichnung de|farbbezeichnung_de|text|1',
'Farbbezeichnung en|farbbezeichnung_en|text|0',
'Farbbezeichnung cz|farbbezeichnung_cz|text|0',
'Farbbezeichnung sk|farbbezeichnung_sk|text|0',
'Blechst&auml;rken|blechstaerken|chk_blechstaerken|1',
'Farbwert|farb_hex|text|1',
'Textur|bild01|image|0',
'Lagerware?|lagerware|rad_lagerware|1',
'Lieferzeit WO|lfz_wochen|text|1',
'aktiv|aktiv|rad_aktiv|1');

$table_used = 'farben';
$id_proxy = 'id';
$bild_proxy = 'bild';
$file_proxy = 'file';
$sortorder_proxy = 'sortorder';
$default_order = 'sortorder';
$default_sortdir = 'asc';
$date_autofill = 'date_start';
$this_prefix = 'Neue ';
$this_topic_s = 'Farben';
$this_topic_p = 'Farben';
$use_functions = '1';
$use_optionbox = '1';
$use_bigpicture = '0';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end', 'date_online', 'date_offline');
$images_width = '240';
$bigimages_width = '0';
$bigimages_height = '0';
$hexbg = '#ffffff';
$downloadfolder = '';
$downloadfiles = '../images/farben/';
$downloadimages = '../images/farben/';
$downloadbigimages = '../images/farben/';
$table_seop = '';
$block_newentry = '';
$block_delete = '';
$json_table = 'faq';
$json_sortorder = 'sortorder';
$json_path = '../_includes/';
$json_filename = '_faq.json';


$chk_blechstaerken_label = array('0,50', '0,60', '0,63', '0,75', '0,88', '1,00', '1,25');
$chk_blechstaerken_value = array('0,50', '0,60', '0,63', '0,75', '0,88', '1,00', '1,25');

$rad_lagerware_label = array('Ja', 'Nein');
$rad_lagerware_value = array('1', '0');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221213
?>