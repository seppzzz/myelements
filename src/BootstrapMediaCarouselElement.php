<?php

namespace Seppzzz\MyElements;

use DNADesign\Elemental\Models\BaseElement;

use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use Silverstripe\Forms\NumericField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use Silverstripe\Forms\CheckboxField;
use Silverstripe\Forms\HeaderField;
use SilverStripe\Forms\Tab;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;

use SilverStripe\ORM\FieldType\DBField;

use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

use Colymba\BulkManager\BulkManager;
use Colymba\BulkUpload\BulkUploader;
	
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

use SilverStripe\Dev\Debug;
//use SilverStripe\Dev\Backtrace;

//Backtrace::backtrace();
// prints a calls-stack

class BootstrapMediaCarouselElement extends BaseElement
{
	
	
    private static $singular_name = 'BootstrapMediaCarouselElement';
    private static $plural_name = 'BootstrapMediaCarouselElements';
    private static $description = 'add a Bootstrap Media Carousel';
	//private static $icon = 'fa fa-picture-o outline  mt-0';
	private static $icon = 'elemental-icon__slideshow';
	
	private static $table_name = 'BootstrapMediaCarouselBlock';
	
	//private static $inline_editable = true;
	//private static $controller_template = 'MyElementHolder';
	
	
	
	private static $db = [
		'FullSize' => 'Boolean',
        'SliderInterval' => 'Varchar',
		'Transition' => 'Varchar',
		'Hide' => 'Boolean',
		'Fade' => 'Boolean',
		'Indicators' => 'Boolean'
    ];
	
	 private static $defaults = [
        'SliderInterval' => '4',
		'Transition' => '1.6',
		//'Height' => '400',
		'Fade' => 1,
		'Indicators' => 0
    ];
	
	private static $has_many = [
		'MediaDataObjects' => MediaDataObject::class
	];
	
	private static $owns = [
        'MediaDataObjects',
    ];
	
	
	 private static $casting = [
        //'SliderInterval' => 'Varchar',
    ];
    
	
	
	public function getMySliderInterval()
    {
        return $this->getField('SliderInterval') * 1000 ;
    }
	
	/*
    public function setSliderInterval($value)
    {
        return $this->setField('SliderInterval', $value * 1000);
    }*/
	
	
	
	public function getCMSFields()
    {
		
		$fields = parent::getCMSFields();
		
		$fields->removeByName('MediaDataObjects');
		
		$fields->insertBefore(LiteralField::create('','<h2>Carousel - Settings:</h2><br><br>'), 'Title');
		$fields->insertAfter(CheckboxField::create('Hide','Hide'), 'Title');
		$fields->insertAfter(TextField::create('SliderInterval' ,'SliderInterval ( sec )'), 'PaddingBottom');
		$fields->insertAfter(TextField::create('Transition','Transition ( sec )'), 'SliderInterval');
		
		 
		/*
		$dropdown =  \SilverStripe\Forms\GroupedDropdownField::create(
			'ProjectID',
			'Project',
			$subcategoryArray
			);
		
		$dropdown->setEmptyString('Select a Project...')
		$fields->insertAfter($dropdown, 'Title');	
		*/
		
		
		$gridFieldConfig = GridFieldConfig_RecordEditor::create();
		$gridFieldConfig->removeComponentsByType('SilverStripe\Forms\GridField\GridFieldSortableHeader');
		$gridFieldConfig->addComponent(new \GridFieldStopHeaderSorting());
		$gridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
		$gridFieldConfig->addComponent(new GridFieldEditableColumns());
		
		$items = $this->MediaDataObjects();
		if (class_exists('Symbiote\GridFieldExtensions\GridFieldOrderableRows') && !$items instanceof UnsavedRelationList) {
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
        }
		
		$gridfield = new GridField('Media', 'Media', $this->MediaDataObjects()->sort("SortOrder"), $gridFieldConfig);
		
		
		$gridFieldConfig->getComponentByType('Symbiote\GridFieldExtensions\GridFieldEditableColumns')->setDisplayFields(array(
			
			/*'Title' => array(
					'callback' => function ($record, $column, $gridfield) {
					return new TextField('Title', 'Title');
					},
					'title' => 'Titel'
				),*/
			
			'Display' => array(
					'callback' => function ($record, $column, $gridfield) {
						$cb = new CheckboxField('Display', 'Display');
						$cb->addExtraClass('project-cb');
					return $cb;
					},
					'title' => 'Display'
				)
		));
		
		
		
		
		//$FieldBulkUpload = new \Colymba\BulkUpload\BulkUploader(); // 'MyImages'
		//$FieldBulkUpload->setUfSetup('setFolderName', 'Carousel-Block-Media'); //->setUfConfig('sequentialUploads', true);	
		//$gridFieldConfig->addComponent($FieldBulkUpload);
		//$gridFieldConfig->addComponent(new \Colymba\BulkManager\BulkManager());
		$gridFieldConfig->addComponent(new \GridFieldLayoutHelper());
		
		$fields->insertAfter(new Tab('Media', 'Media'), 'Main');
		$fields->addFieldsToTab('Root.Media', [
			$gridfield
		]);
		
		/*
		$fields->insertAfter(new Tab('Meta', 'Meta'), 'Settings');
		$fields->addFieldsToTab('Root.Meta', [
			TextField::create("MetaTitle", 'MetaTitle'),
			TextareaField::create("MetaDescription", 'MetaDescription')
		]);
		*/	

        
        return $fields;
    }
	
	
	
	
	

	protected function provideBlockSchema()
	{
		$blockSchema = parent::provideBlockSchema();
		//if ($this->Project() && $this->Project()->getTitle() ) {
			/*if ($this->MediaDataObjects()->First()) {
				$blockSchema['fileURL'] = $this->MediaDataObjects()->First()->Image()->getURL();
			}*/
			$blockSchema['fileTitle'] = ''; //$this->Project()->getTitle();
		//}
		return $blockSchema;
	}

	
    public function getType()
    {
        return 'Bootstrap-Media-Slider';
    }
	
	
	
	public function convertSeconds($value, $digit = false)
	{
		
		if($digit){
			$value = preg_replace( '/,/', '.', $value);
		}else{
			$value = $value * 1000;
		}
		
		return $value;
		
	}
	
	
	public function onBeforeWrite() 
	{
		parent::onBeforeWrite();
		$this->SliderInterval = $this->convertSeconds($this->SliderInterval, true);
		$this->Transition = $this->convertSeconds($this->Transition, true);
	}
	
	
	
	
}























