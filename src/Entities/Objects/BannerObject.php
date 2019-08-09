<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 21.06.2019
 * Time: 15:38
 */

namespace SphereMall\MS\Entities\Objects;

use SphereMall\MS\Entities\Entity;

/**
 * Class BannerObject
 * @package SphereMall\MS\Entities\Objects
 * @property int $id
 * @property string $backgroundImage 
 * @property string $textColor 
 * @property string $pageUrl 
 * @property string $blockOpacity 
 * @property string $cssClass 
 * @property string $alignDescription 
 * @property string $buttonLabel 
 * @property string $backgroundColor 
 * @property string $additionalMedia 
 * @property string $backgroundMobileImage 
 * @property int $fullBannerClickable 
 * @property int $titleTag 
 * @property string $title 
 * @property string $html 
 */
class BannerObject extends Entity
{
    #region [Properties]
    public $id;
    public $backgroundImage;
    public $textColor;
    public $pageUrl;
    public $blockOpacity;
    public $cssClass;
    public $alignDescription;
    public $buttonLabel;
    public $backgroundColor;
    public $additionalMedia;
    public $backgroundMobileImage;
    public $fullBannerClickable;
    public $titleTag;
    public $title;
    public $html;
    #endregion
}