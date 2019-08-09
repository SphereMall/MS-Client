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
 * @property string $name
 * @property string $iFrameLink
 * @property string $titleTag
 * @property string $title
 */
class ContactObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $iFrameLink;
    public $titleTag;
    public $title;
    #endregion
}