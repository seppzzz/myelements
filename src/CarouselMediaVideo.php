<?php

namespace Seppzzz\MyElements;


use SilverStripe\Security\Member;
use SilverStripe\Dev\Backtrace;
use BurnBright\ExternalURLField\ExternalURLField;
use Embed\Adapters\Adapter;
use Embed\Embed;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\View\HTML;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\FilenameParsing\HashFileIDHelper;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\Core\Convert;
use SilverStripe\Control\ContentNegotiator;
use SilverStripe\Core\Config\Config;

//use till\video\src\VideoPage;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;


use SilverStripe\Dev\Debug;

use SilverStripe\Assets\FileNameFilter;



class CarouselMediaVideo extends MediaDataObject
{
    private static $table_name = 'CarouselMediaVideo';
    private static $singular_name = 'MediaVideo';
    private static $plural_name = 'MediaVideos';
	
	private static $icon = 'fa fa-video-camera outline  mt-0 ';

    private static $extensions = [
        //Versioned::class
    ];
	
	//public function canView($member = null) {return true;}

    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'Text',
		'AdditionalText' => 'Varchar',
        'SourceURL' => 'ExternalURL',
        'EmbedThumbnailURL' => 'ExternalURL',
        'EmbedHTML' => 'HTMLText',
        'EmbedWidth' => 'Int',
        'EmbedHeight' => 'Int',
        'EmbedAspectRatio' => 'Decimal',
        'ProviderURL' => 'ExternalURL',
        'ProviderVideoID' => 'Varchar',
        'ImageMode' => 'Varchar(10)',
		'SortOrder' => 'Int',
		'URLSegment' => 'Varchar(255)',
		'MetaTitle' => 'Varchar(255)',
		'MetaDescription' => 'Varchar(255)',
		'LossLessPad' => 'Boolean',
		'PadColor' => 'Varchar(255)'
    ];
	
	/*private static $indexes = [
        'SortOrder' => true,
    ];*/

    private static $has_one = [
        'CustomThumbnail' => Image::class,
		'AutoThumbnail' => Image::class,
		//'VideoPage' => VideoPage::class,
		//'VideoCatObject' => 'VideoCatObject',
		//'VideoObject' => 'MixedProjectPage'
    ];
	
	private static $cascade_deletes = [
        'CustomThumbnail',
		'AutoThumbnail'
    ];
	
	

    private static $defaults = [
        'ImageMode' => 'embed'
    ];

    private static $owns = [
        'CustomThumbnail',
		'AutoThumbnail'
    ];
	
	private static $searchable_fields = [
      'Title'
   ];

    private static $summary_fields = [
        'Thumbnail',
        'getMyTitle' => 'Titel'
    ];
	
    /*private static $field_labels = [
        'CustomThumbnail' => 'Custom Image',
		'Title' => 'Titel'
    ];*/
	
	public function getMyTitle(){
		return $this->Title;
	}
	
	
	public static function getIconClass()
    {
        return 'fa fa-video-camera'; // Font Awesome icon for videos
    }
	
	public static function getSingularName()
    {
        return self::$singular_name;
    }
	
	
    public function getThumbnail($returnUrl = false)
    {
		
		if($returnUrl){
			return $this->EmbedThumbnailURL;
		}
        $thumb = null;
        if ($this->ImageMode === 'embed') {
            $thumb = DBField::create_field(
                'HTMLFragment',
                HTML::createTag('img', ['src' => $this->EmbedThumbnailURL, 'width' => '75']) //->CropWidth(100)
            );
        }
        else if ($this->CustomThumbnailID) {
            $thumb = $this->CustomThumbnail()->ThumbnailIcon(75,40);
        }
		
		//Debug::show($thumb);
        return $thumb;
    }

    public function getCMSFields()
    {
        
		//Debug::show($this->EmbedThumbnailURL);
		
		//$fields = parent::getCMSFields();
		//return $fields;
		
		
		if ($this->isInDB() && $this->SourceURL) {

            $fields = FieldList::create(
                TabSet::create(
                    'Root',
                    Tab::create(
                        'Main',
                        TextField::create('Title', $this->fieldLabel('Title'))->setCustomValidationMessage('You missed me.'),
                        TextareaField::create('Description', $this->fieldLabel('Description')),
						TextField::create('AdditionalText', $this->fieldLabel('AdditionalText')),
                        FieldGroup::create(
                            'Preview',
                            LiteralField::create('EmbedPreview', $this->EmbedHTML)
                        )
                    ),
                    Tab::create(
                        'Image',
						 FieldGroup::create(
                            'lossless pad',
							CheckboxField::create('LossLessPad'),
							TextField::create('PadColor', 'PadColor HEX #')
						),
                        OptionsetField::create(
                            'ImageMode',
                            $this->fieldLabel('ImageMode'),
                            [
                                'embed' => 'Use Provider Thumbnail Image',
                                'custom' => 'Upload Custom Image'
                            ]
                        ),
                        $thumbPreviewField = Wrapper::create(
                            FieldGroup::create(
                                'Provider Thumbnail',
                                LiteralField::create(
                                    'ThumbnailPreview',
                                    '<img src="'
                                        . $this->EmbedThumbnailURL
                                        . '" style="width: 300px; height: auto;"'
                                        . '>'
                                )
                            )
                        ),
                        $customImageWrapper = Wrapper::create(
                            $customImageField = UploadField::create(
                                'CustomThumbnail',
                                $this->fieldLabel('CustomThumbnail')
                            )
                        )
                    ),
                    Tab::create(
                        'Embed',
                        TextField::create('ProviderVideoID'),
                        ReadonlyField::create('EmbedWidth'),
                        ReadonlyField::create('EmbedHeight'),
                        ReadonlyField::create('EmbedAspectRatio'),
						//LiteralField::create('', '<h2>Fullscreen option:</h2>webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" <br><br>'),
                        TextareaField::create('EmbedHTML')
                    ),
                    Tab::create(
                        'Source',
                        ExternalURLField::create('SourceURL'),
                        FieldGroup::create(
                            'Refresh?',
                            CheckboxField::create('DoRefreshFromSource')
                        )
                    ),
					Tab::create(
						'Meta',
						TextField::create("MetaTitle", 'MetaTitle'),
						TextareaField::create("MetaDescription", 'MetaDescription')
					)
			
                )
            );

            $thumbPreviewField->displayIf('ImageMode')->isEqualTo('embed');
            $customImageWrapper->displayIf('ImageMode')->isEqualTo('custom');
            $customImageField->setAllowedFileCategories('image');
			$customImageField->setFolderName('videoThumbs');

        }
        else {
            $fields = FieldList::create(
                TabSet::create(
                    'Root',
                    Tab::create(
                        'Main',
                        ExternalURLField::create(
                            'SourceURL',
                            $this->fieldLabel('SourceURL')
                        ),
                        HiddenField::create('DoRefreshFromSource', null, 1)
                    )
                )
            );
        }

        return $fields;
    }
	
	/*protected function onBeforeWrite() {
		if (!$this->SortOrder) {
			$this->Sort = SimpleVideo::get()->max('SortOrder') + 1;
		}
		
		parent::onBeforeWrite();
	}*/
	
	
	public function getCMSValidator()
    {
        return new RequiredFields([
            'Title'
        ]);
    }
	
	

    public function saveDoRefreshFromSource($value)
    {
        if ($value) {
            $this->doRefreshFromSource();
            $this->DoRefreshFromSource = 0;
        }
    }

    public function doRefreshFromSource()
    {
        if (!$this->SourceURL) {
            return false;
        }
		
		/*
		We need to use Emed Vesion 3
		https://github.com/oscarotero/Embed/tree/v3.x
		The function Embed::create is deprecated at later versions than V3
		*/

        $embed = Embed::create(
            $this->SourceURL,
            [
                'choose_bigger_image' => true
            ]
        );

        if ($embed && $embed instanceof Adapter) {
            $this->Title = $embed->title;
            $this->Description = $embed->description;
            $this->EmbedThumbnailURL = $embed->image;
            $this->EmbedHTML = $embed->code;
            $this->EmbedWidth = $embed->width;
            $this->EmbedHeight = $embed->height;
            $this->EmbedAspectRatio = $embed->aspectRatio;
            $this->ProviderURL = $embed->url;

            $providers = $embed->getProviders();
            if (isset($providers['oembed'])) {
                $oembed = $providers['oembed'];
                $this->ProviderVideoID = $oembed->getBag()->get('video_id');
            }

            return true;
        }

        $this->SourceURL = '';
        return false;
    }

    public function validate()
    {
        $result = parent::validate();
        if (!$this->SourceURL || empty($this->SourceURL)) {
            $result->addError('You must provide a valid Source URL');
        }
        return $result;
    }
	
	
	public function getEmbedThumbnailRatio()
    {
		if(!$this->EmbedThumbnailURL){
			return null;
		}
		
		
		$image_size_array = getimagesize($this->EmbedThumbnailURL);
		$image_width = $image_size_array[0];
		$image_height = $image_size_array[1];
		$aspectRatio = $image_size_array[0] / $image_size_array[1] * 100;
		
		//return DBField::create_field('ThumbnailRatio', $aspectRatio / 100, null, 2);
		return round($aspectRatio / 100, 2 );
		//$numbers = array($image_size_array[0], $image_size_array[1] );
		//$everything = array_sum( $numbers );
		//return round( $aspectRatio / $everything * 100, 2 );
		
		//return number_format($aspectRatio / $everything * 100, 2) . '%';
	}
	
	

    public function getEmbedAspectRatioPercent()
    {
        $aspectRatio = $this->EmbedAspectRatio;
        if (!$aspectRatio) {
            if (!$this->EmbedWidth || !$this->EmbedHeight) {
                return null;
            }
            $aspectRatio = $this->EmbedHeight / $this->EmbedWidth * 100;
        }
        return DBField::create_field('Percentage', $aspectRatio / 100, null, 2);
    }

    public function forTemplate()
    {
        return null;
    }
	
	
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		
		if (!$this->MenuTitle) {
			$this->MenuTitle = $this->Title;
		}
		$filter = URLSegmentFilter::create();
		if (!$this->URLSegment) {
			$this->URLSegment = $this->Title;
		}
		$this->URLSegment = $filter->filter($this->URLSegment);
		if (!$this->URLSegment) {
			$this->URLSegment = uniqid();
		}
		$count = 2;
		while (static::get_by_url_segment($this->URLSegment, $this->ID)) {
			// add a -n to the URLSegment if it already existed
			$this->URLSegment = preg_replace('/-[0-9]+$/', null, $this->URLSegment) . '-' . $count;
			$count++;
		}
		
		$this->createImage();
	
	}
	
	
	
	
	public function onAfterWrite() { 
		parent::onAfterWrite();
		
		if ($this->AutoThumbnailID) {
        	$this->AutoThumbnail()->publishSingle();
		}
	}
	
	
	
	public function deleteImage(){
		if($this->AutoThumbnail()->exists){
			
		}
	}
	
	
	public function createImage()
    {
		
		
		/*
		This yml is needed to correctly publish the files- thumbnail:
		
		---
		Name: app_imgix
		After: assetadmingraphql-dependencies
		---
		SilverStripe\Core\Injector\Injector:
		  SilverStripe\AssetAdmin\Model\ThumbnailGenerator.graphql:
			class: SilverStripe\AssetAdmin\Model\ThumbnailGenerator
			properties:
			  Generates: true
		*/
		
		
		//Controller::curr()->getResponse()->addHeader('X-Status', rawurlencode('createImagecalled.'));
        $url = $this->EmbedThumbnailURL;
		//Debug::show($url);
        $url = ltrim($url, '/');
        $file = Director::getAbsFile($url);
        $pathInfo = pathinfo($file);
       // if (!in_array(strtolower($pathInfo['extension']),['jpg', 'jpeg', 'png'])) {
           // return null;
       // }
        //$fileName = $pathInfo['filename'];
		//$fileName = $this->URLSegment.'-'.basename($this->EmbedThumbnailURL);
		//$fileName = $this->URLSegment.'-'.$this->ID.'.jpg'; //.basename($this->EmbedThumbnailURL);
		$fileName = $this->URLSegment.'-'.md5_file($this->EmbedThumbnailURL).'.jpg';
		$saveImage = $fileName;
		
		//Debug::show($saveImage);

        $filter    = FileNameFilter::create();
        $saveImage = $filter->filter($saveImage);
        $tmpFile   = tempnam("/tmp", "jpg");

        $image = DataObject::get_one(Image::class, "`Name` = '{$saveImage}'");
		

        if (!$image) {
			$folder = Folder::find_or_make('videoThumbs');
            $folderObject = DataObject::get_one(Folder::class, "`Name` = 'videoThumbs'");
			$tmpFolder = 'videoThumbs/';
			
            if ($folderObject) {
				$pic = imagecreatefromstring(file_get_contents($url));	
				if(imagejpeg($pic, $tmpFile)){
					
                    $image = new Image();
					$image->FileFilename = $folderObject->Name.'/'.$saveImage;
					$image->ParentID = $folderObject->ID;
					$image->Name = $fileName;
                    $image->setFromLocalFile($tmpFile, $folderObject->Name.'/'.$saveImage);
                    $image->setFilename($folderObject->Name.'/'.$saveImage);
                    $image->write();
					$image->doPublish();
					$this->AutoThumbnail()->$image;
					$this->AutoThumbnailID = $image->ID;
					$this->AutoThumbnail()->doPublish(); 
                }
            }
        }
	}
	
	
	public function shortInfoText(){
	
		$descr =  preg_split('/\r\n|\r|\n/', $this->Description);
		return DBField::create_field('HTMLVarchar', '<span class="mixed-project-page-thumb-info-title">'.$this->Title.'</span>&nbsp;<span class="mixed-project-page-thumb-info-descr">'.$descr[0].'</span>');
		
	}
	
	
	
	
	protected static $_cached_get_by_url = array();
	
	public static function get_by_url_segment($str, $excludeID = null) {
		//return 'TEST';
		
		if (!isset(static::$_cached_get_by_url[$str])) {
			$list = static::get()->filter('URLSegment', $str);
			if ($excludeID) {
				$list = $list->exclude('ID', $excludeID);
			}
			$obj = $list->First();
			static::$_cached_get_by_url[$str] = ($obj && $obj->exists()) ? $obj : false;
		}
		return static::$_cached_get_by_url[$str];
	}
	
	
	/*
	public function Link()
    {
        //return Controller::join_links(Director::BaseURL().'video', $category->VideoPage()->URLSegment, $category->URLSegment,  $this->URLSegment);
		//return $this->VideoPage()->Link('video/'.$this->URLSegment);
		//return Controller::join_links(Director::BaseURL().'video',  $this->VideoPage()->URLSegment, $this->URLSegment);
		//return Controller::join_links(Director::BaseURL().'video',  $this->VideoCatObject()->VideoPage()->URLSegment, $this->URLSegment);
		return Controller::join_links(Director::BaseURL().'show',  $this->VideoObject()->URLSegment, $this->URLSegment);
		
    }
	
	public function AbsoluteLink() {
		return Director::absoluteURL($this->Link());
	}
	*/
	
	
	
	
	
	
}
