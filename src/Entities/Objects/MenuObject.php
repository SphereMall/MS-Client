<?php
namespace SphereMall\MS\Entities\Objects;

use SphereMall\MS\Entities\Entity;

/**
 * Class MenuObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $name
 * @property string $language
 */
class MenuObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $language;
    #endregion
}