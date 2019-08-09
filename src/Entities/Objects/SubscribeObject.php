<?php
namespace SphereMall\MS\Entities\Objects;

use SphereMall\MS\Entities\Entity;

/**
 * Class SubscribeObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $name
 * @property string $html
 */
class SubscribeObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $html;
    #endregion
}