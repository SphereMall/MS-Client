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
 * Class HTMLObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $name
 * @property string $text
 */
class HTMLObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $text;
    #endregion
}