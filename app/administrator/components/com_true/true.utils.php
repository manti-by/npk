<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum 		   **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru         **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
**   Hack category veiw by Yunoshev Victor         **
\***************************************************/
defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');
function true_get_cat_path($cat){
	global $database;

	$cat = intval($cat);
	$parent = 1000;
	$path = "";

	while ($parent) {
		$database->setQuery( "select * from #__true_catg where cid=$cat" );
		$rows    = $database->loadObjectList();
		$row     = &$rows[0];
		$parent  = $row->parent;
		$name    = $row->name;
		$path ? $path = $name . ' :: ' . $path : $path = $name;

		$cat = $parent;
	}
	return $path . " ";
}

function true_get_img_title($id){
	global $database;

	$database->setQuery( "select imgtitle from #__true where id=$id" );
	$rows    = $database->loadObjectList();
	$row     = &$rows[0];
	$title  = $row->imgtitle;

	return $title;
}

function true_get_count_entries($id){
//----+ ������ ���������� ��������� � ��������� ��������� TrueGallery
	global $database;

	$query = "SELECT count(*) FROM #__true"
		. "\n WHERE ";
	if (true_get_count_subcats($id, 0)) {
		$cats_obj = true_get_all_subcats($id, null);
		$cats_arr = array();
		foreach ($cats_obj as $cat_obj) { $cats_arr[] = $cat_obj->cid; }
		$query .= "catid in ($id, ". implode(",", $cats_arr). ")";
	}
	else {
		$query .= "catid = $id";
	}
	$query .= " AND published=1" ;
	$database->setQuery($query);
	$entries = $database->loadresult();

	return $entries;
}

function true_get_subcats_id($id){
//----+ ������ ID ������������ TrueGallery
	$query = "";
	if (true_get_count_subcats($id, 0)) {
		$cats_obj = true_get_all_subcats($id, null);
		$cats_arr = array();
		foreach ($cats_obj as $cat_obj) { $cats_arr[] = $cat_obj->cid; }
		$query .= "catid in ($id,". implode(",", $cats_arr). ")";
	}
	else {
		$query .= "catid = $id";
	}
	return $query;
}

function true_get_subcats($id){
//----+ ������ ������������ TrueGallery
	global $database;

	$query = "SELECT cid FROM #__true_catg"
		. "\n WHERE parent = '$id'  AND published=1" ;
	$database->setQuery($query);
	$cats = $database->loadObjectList();

	return $cats;
}

function true_get_all_subcats($id, $cats_arr){
//----+ ������ ������������ TrueGallery
	global $database;

	$query = "SELECT cid FROM #__true_catg"
		. "\n WHERE parent = '$id'  AND published=1" ;
	$database->setQuery($query);
	$cats = $database->loadObjectList();

	if ($cats_arr == null) $cats_arr = array();

	if (count($cats)) {
		$cats_arr = array_merge($cats_arr, $cats);
		foreach ($cats as $cat) true_get_all_subcats($cat->cid, $cats_arr);
	}

	return $cats_arr;
}

function true_get_count_subcats($id, $count){
//----+ ������ ���������� ������������ TrueGallery
	global $database;

	$query = "SELECT cid FROM #__true_catg"
		. "\n WHERE parent = '$id'  AND published=1" ;
	$database->setQuery($query);
	//$rows = $database->loadresult();
	$rows = $database->loadObjectList();

	if (count($rows)) {
		$count = $count + count($rows);
		foreach ($rows as $row) true_get_count_subcats($row->cid, $count);
	}

	return $count;
}
?>