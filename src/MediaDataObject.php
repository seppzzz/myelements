<?php


namespace Seppzzz\MyElements;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use TheWebmen\MediaField\Form\MediaField;

class MediaDataObject extends DataObject
{
    
	private static $table_name = 'MediaDataObject';
	private static $singular_name = 'MediaData';
	private static $plural_name = 'MediaData';
	
	
	private static $db = [
		'SortOrder' => 'Int',
		'Title' => 'Varchar(255)',
		'Caption' => 'Varchar(255)',
		'Display' => 'Boolean',
		'IsOverlayText' => 'Boolean',
		'Crop' => 'Int',
        'MediaType' => 'Varchar(255)', // Assuming 'MediaType' is a dropdown
        'MediaImage' => 'Int',         // Assuming 'MediaImage' is a relationship to a file
        'MediaVideo' => 'Text',        // Assuming 'MediaVideo' is a text field
        'MediaVideoEmbedUrl' => 'Varchar(255)',  // Assuming you're saving an embedded video URL
        'MediaVideoType' => 'Varchar(255)'       // Assuming you're saving video provider type
    ];
	
	
	private static $has_one = [
		//'Image' => Image::class,
		'BootstrapMediaCarouselElement' => BootstrapMediaCarouselElement::class
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
		
		$fields->removeByName('MediaType');
		$fields->removeByName('MediaImage');
		$fields->removeByName('MediaVideo');

        $mediaField = MediaField::create(
            FieldList::create(), // Empty FieldList as we're not adding fields to it directly
            'MediaType',         // Type field name
            'MediaImage',        // Image field name
            'MediaVideo'         // Video field name
        );
        
        $fields->addFieldToTab('Root.Main', $mediaField);

        return $fields;
    }
}
