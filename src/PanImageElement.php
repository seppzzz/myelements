<?php

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormField;
use Silverstripe\Forms\CheckboxField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\SelectionGroup;
use SilverStripe\Forms\SelectionGroup_Item;
use SilverStripe\Forms\OptionsetField;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\HTML;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\Backtrace;

class PanImageElement extends BaseElement
{
	
	
    private static $singular_name = 'PanImageElement';
    private static $plural_name = 'PanImageElements';
    private static $description = 'add a PanImage';
	//private static $icon = 'fa fa-picture-o outline  mt-0';
	private static $icon = 'elemental-icon__single_image';
	
	private static $table_name = 'PanImageBlock';
	
	//private static $inline_editable = true;
	//private static $controller_template = 'MyElementHolder';
	
	
	private static $db = [
        'ImageTitle' => 'Text',
		'IsOverlayText' => 'Boolean',
		'FullSize' => 'Boolean',
		'Crop' => 'Int'
    ];
	
	 private static $defaults = [
       
    ];
	
	private static $has_one = [
		'PanImage' => Image::class
	];
	
	private static $owns = [
        'PanImage',
    ];
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Crop');

		//$items = array('0//no Crop' => new LiteralField('one', ''), '1//16:9' => new LiteralField('two', ''), '2//5:4' => new LiteralField('two', ''));
		//['0' => 'no Crop', '1' => '16:9', '2' => '5:4']

		$upload = new UploadField('PanImage', 'Bild'); 

		$fields->addFieldsToTab('Root.Main', [
			$upload,
			OptionsetField::create('Crop', 'Crop', ['0' => 'no Crop', '1' => '16:9', '2' => '4:3', '3' => '5:2'])->setTitle('Crop'), //, '4' => '1:1', '5' => '2:3'
			CheckboxField::create('IsOverlayText', 'Layer-Text'),
			CheckboxField::create('FullSize', 'Full Size'),
			TextareaField::create('ImageTitle', 'Text')
			]
		);

		return $fields;
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
	
	
	
	
	public function getSummary()
    {
        if ($this->PanImage()->exists()) {
            return $this->getSummaryThumbnail() . $this->PanImage()->Title;
        }
        return '';
    }

    /**
     * Return file title and thumbnail for summary section of ElementEditor
     *
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->PanImage()->exists()) {
            //$blockSchema['fileURL'] = $this->PanImage()->CMSThumbnail()->getURL();
			$blockSchema['fileURL'] = $this->PanImage()->getURL();
            $blockSchema['fileTitle'] = $this->PanImage()->getTitle();
        }
        return $blockSchema;
    }

    /**
     * Return a thumbnail of the file, if it's an image. Used in GridField preview summaries.
     *
     * @return DBHTMLText
     */
	
    /*public function getSummaryThumbnail()
    {
        $data = [];

        if ($this->PanImage()->exists()) {
			// Stretch to maximum of 36px either way then trim the extra off
			if ($this->PanImage()->getOrientation() === Image_Backend::ORIENTATION_PORTRAIT) {
				$data['Image'] = $this->PanImage()->ScaleWidth(300); //->CropHeight(36);
			} else {
				$data['Image'] = $this->PanImage()->ScaleHeight(300); //->CropWidth(36);
			}
		}
       

        return $this->customise($data)->renderWith(__CLASS__ . '/SummaryThumbnail');
    }
*/

	
	
	
	
    public function getType()
    {
        return 'PanImage';
    }
	
	
	
	public function onBeforeWrite() 
	{
		parent::onBeforeWrite();
	
	}
	
	
	public function myLink()
	{
		return $this->owner->Link();
	}
	
	
	
	
}























