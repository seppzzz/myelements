<?php


use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use Silverstripe\Forms\CheckboxField;

use SilverStripe\Dev\Debug;


class CarouselImage extends DataObject {
	
	private static $table_name = 'CarouselImage';
	private static $singular_name = 'Image';
	private static $plural_name = 'Images';
	
	/*
	public function canEdit($member = null) {
		return true;
	}
	
	public function canDelete($member = null) {
		return true;
	}

	public function canView($member = null) {
		return true;
	}

	public function canCreate($member = null, $context = []) {
		 return true;
	}
*/
	
	private static $db = [
		'SortOrder' => 'Int',
		'Title' => 'Varchar(255)',
		'Caption' => 'Varchar(255)',
		'Display' => 'Boolean',
		'IsOverlayText' => 'Boolean',
		'Crop' => 'Int'
	];
	
	private static $has_one = [
		'Image' => Image::class,
		'BootstrapCarouselElement' => BootstrapCarouselElement::class
	];
	
	private static $cascade_deletes = [
        'Image',
    ];
	
	private static $owns = [ 
		'Image' 
	];
	
	
	private static $defaults = [
		'Display' => '1'
    ];
	
	public function getCMSFields()
	{ 
		
  		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root.Main', 'BootstrapCarouselElementID');
		$fields->removeFieldFromTab('Root.Main', 'Caption');
		$fields->removeFieldFromTab('Root.Main', 'SortOrder');
		$fields->removeByName('Crop');
		
		$crop = OptionsetField::create('Crop', 'Crop', ['0' => 'no Crop', '1' => '16:9', '2' => '4:3', '3' => '5:2'])->setTitle('Crop');
		

		$ImageField = new UploadField('Image', 'Image');
		
		$ImageField->getValidator()->setAllowedExtensions(['jpeg', 'jpg', 'png', 'gif']);
		
		$sizeMB = 1; // 3 MB
		$size = $sizeMB * 1024 * 1024; // 1 MB in bytes
		$ImageField->getValidator()->setAllowedMaxFileSize($size); 
		
			
		$fields->addFieldToTab("Root.Main", new TextField('Title', 'Titel'));
		$fields->addFieldToTab("Root.Main", new CheckboxField('Display', 'Display'));
		
		$fields->addFieldToTab("Root.Main", new TextareaField('Caption', 'Caption'));
		$fields->addFieldToTab("Root.Main", $ImageField);
		$fields->addFieldToTab("Root.Main", $crop);
		
		
		return $fields;
	}
	
	private static $summary_fields = array( 
		'Thumbnail' => 'Bild',
		'Caption' => 'Caption - Text'
	);
  
	public function getThumbnail()
	{ 
		if($this->Image()->exists() && $this->Image()->isPublished()){
			return $this->Image()->ThumbnailIcon(75,40);
		}else{
			return false;
		}
		//return $this->Image()->SetRatioSize(40,40);
		// $thumb = $this->Image()->ThumbnailIcon(75,40);
	}
	
	
	
	protected function onAfterWrite()
	{
        parent::onAfterWrite();
    }
	
	
	public function getCroppedHeight($value = '')
	{
		//'0' => 'no Crop', '1' => '16:9', '2' => '4:3', '3' => '5:2', '4' => '1:1', '5' => '2:3'
		
		switch($value){
			case 0: // no crop
				return '0';
				break;
			case 1: // 16:9
				return '675';
				break;
			case 2: // 4:3
				return '900';
				break;
			case 3: // 5:2
				return '480';
				break;
			case 4: // 1:1
				return '1200';
				break;
			case 5: // 2:3
				return '1800';
				break;
		}
		return '0';
		
	}
	
	
	
	
}











