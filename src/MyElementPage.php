<?php

//namespace Seppzzz\MyElements;


class MyElementPage extends Page
{
	
	private static $allowed_children = 'none';
	private static $can_be_root = true;
	//private static $icon = "till/mycustomextentions/img/impressum.png";
	//private static $icon = 'app/images/impressum-file.png';
	private static $icon_class = 'font-icon-block-layout'; //p-mail
	
	//private static $icon = 'memberprofiles/images/memberprofilepage.png';
	
	private static $description = "ElementBlock - Seite";
	private static $singular_name = 'ElementBlock Seite';
	private static $plural_name = 'ElementBlock Seiten';
	
	//private static $table_name = 'ArticlePage';
	
}