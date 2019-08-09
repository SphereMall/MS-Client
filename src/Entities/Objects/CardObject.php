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
 * Class ContactObject
 * @package SphereMall\MS\Entities\Objects
 * @property int $id
 * @property string $title
 * @property string $media
 * @property string $pageUrl
 * @property string $cssClass
 * @property string $text
 * @property string $backgroundImage
 * @property string $buttonLabel
 * @property string $backgroundColor
 * @property string $titleTag
 * @property string $blockType
 */
class CardObject extends Entity
{
    #region [Properties]
    public $id;
    public $title;
    public $media;
    public $pageUrl;
    public $cssClass;
    public $text;
    public $backgroundImage;
    public $buttonLabel;
    public $backgroundColor;
    public $titleTag;
    public $blockType;
    #endregion
}