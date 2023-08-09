<?php


namespace Seppzzz\MyElements;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
//use TheWebmen\MediaField\Form\MediaField;
use SilverStripe\Forms\TextField;

class MediaDataObject extends DataObject
{
    
	private static $table_name = 'MediaDataObject';
	private static $singular_name = 'MediaData';
	private static $plural_name = 'MediaData';
	
	
	private static $db = [
		'Title' => 'Varchar(255)'
    ];
	
	private static $belongs_many_many = [
        "MediaCarouselElement" => BootstrapMediaCarouselElement::class,
    ];
	
	
	
	private static $cascade_deletes = [
        //'Image',
    ];
	
	private static $owns = [ 
		//'Image' 
	];
	

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
		

        return $fields;
    }
}
