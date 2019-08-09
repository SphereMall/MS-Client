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
 * Class SliderObject
 * @package SphereMall\MS\Entities\Objects
 * @property int $id
 * @property string $name
 * @property string $backgroundColor
 * @property string $backgroundImage
 * @property string $backgroundMobileImage
 * @property string $cssClass
 * @property string $title
 * @property int $numberOfBlocks
 * @property int $autoplay
 * @property array $sliderImage
 * @property array $sliderVideo
 */
class SliderObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $backgroundColor;
    public $backgroundImage;
    public $backgroundMobileImage;
    public $cssClass;
    public $title;
    public $numberOfBlocks;
    public $autoplay;
    public $sliderImage;
    public $sliderVideo;
    #endregion
}