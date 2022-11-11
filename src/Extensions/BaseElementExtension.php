<?php

namespace Seppzzz\MyElements\Extensions;

//use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;

//use DNADesign\Elemental\Forms\TextCheckboxGroupField;
//use Heyday\ColorPalette\Fields\ColorPaletteField;
//use TractorCow\Colorpicker\Color;
//use TractorCow\Colorpicker\Forms\ColorField;

//use SilverStripe\Dev\Debug;



class BaseElementExtension extends DataExtension {
	
	
	private static $db = [
        'PaddingTop' => 'Int',
        'PaddingBottom' => 'Int',
		//'BackgroundColor' => 'Varchar(255)'
		//'BgColor' => Color::class
    ];
	
	public function updateCMSFields(SilverStripe\Forms\FieldList $fields) 
	{
		/*
		$fields->removeByName('TopMargin');
		$fields->removeByName('BottomMargin');
		*/
		
		$fields->insertAfter( NumericField::create('PaddingTop', 'Padding-Top'), 'Title');
		$fields->insertAfter( NumericField::create('PaddingBottom', 'Padding Bottom'), 'PaddingTop');
		
		
		//$fields->insertAfter(TractorCow\Colorpicker\Forms\ColorField::create('BgColor', 'Background color')->addExtraClass('colorfield'), 'BottomMargin');
		/*
		$fields->insertAfter( Heyday\ColorPalette\Fields\GroupedColorPaletteField::create('BackgroundColor', 'Background Color',
			array(
				'Primary Palette' => array(
					'#232839' => '#232839',
					'Black' => '#000'
				),
				'Secondary Palette' => array(
					'Blue' => 'blue',
					'Red' => 'red'
				)
			)), 'BottomMargin');
		*/
		
	}
	
	
	
	
	
}