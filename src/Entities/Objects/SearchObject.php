<?php
/**
 * Created by SergeyBondarchuk.
 * 23.04.2018 17:45
 */

namespace SphereMall\MS\Entities\Objects;

use SphereMall\MS\Entities\Entity;

/**
 * Class SearchObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $title
 * @property string $pageUrl
 * @property string $cssClass
 * @property string $backgroundImage
 * @property string $backgroundColor
 * @property string $autocomplete
 */
class SearchObject extends Entity
{
    #region [Properties]
    public $id;
    public $title;
    public $pageUrl;
    public $cssClass;
    public $backgroundImage;
    public $backgroundColor;
    public $autocomplete;
    #endregion
}