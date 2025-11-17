<?php
$arr_admin = array(
'Handle|handle|text|1',
'Paketname|paketname|text|1',
'Untertitel|paketsubline|text|1',
'Inhalt|paketliste|area|0',
'Paketpreis Art|paketab|rac_paketab|0',
'Paketpreis brutto|paketpreis|text|1',
'Paketinfo|paketinfo|text|0');

$table_used = 'pakete';
$id_proxy = 'id';
$bild_proxy = 'bild';
$file_proxy = 'file';
$sortorder_proxy = '';
$default_order = 'handle';
$default_sortdir = 'asc';
$date_autofill = 'datum';
$this_prefix = 'Neuer ';
$this_topic_s = 'Eintrag';
$this_topic_p = 'Eintr&auml;ge';
$use_functions = '1';
$use_optionbox = '0';
$use_bigpicture = '0';
$use_calendar = '0';
$use_doubledigit = '1';
$names_calendars = array('date_start', 'date_end', 'date_online');
$images_width = '350';
$bigimages_width = '1000';
$bigimages_height = '800';
$hexbg = '#ffffff';
$downloadfolder = '';
$downloadfiles = '../downloads/';
$downloadimages = '../images/tagcloud/';
$downloadbigimages = '../images/tagcloud/big/';
$table_seop = '';
$block_newentry = '';
$viewonly = '';
$block_delete = 'no';
$export_json = 1;
$json_mode = "assoc";
$json_idfield = "handle";
$json_table = 'pakete';
$json_sortorder = 'pid';
$json_path = '../_includes/';
$json_filename = '_pakete.json';

$rac_paketab_label = array('Preis fix', 'Preis ab');
$rac_paketab_value = array('0', '1');

$rad_aktiv_label = array('Ja', 'Nein');
$rad_aktiv_value = array('1', '0');

// ©2022 - carpe diem Werbeagentur, alle Rechte vorbehalten.
// created: 221210
?>