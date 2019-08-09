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
 * Class ListObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $title
 * @property string $shortDescription
 * @property string $backgroundImage
 * @property string $listType
 * @property string $cssClass
 * @property string $titleTag
 * @property string $backgroundColor
 * @property array $listItem
 */
class ListObject extends Entity
{
    #region [Properties]
    public $id;
    public $title;
    public $shortDescription;
    public $backgroundImage;
    public $listType;
    public $cssClass;
    public $titleTag;
    public $backgroundColor;
    public $listItem = [];
    #endregion
}