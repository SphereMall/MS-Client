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
 * Class ImageLinkObject
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $name
 * @property string $illustration
 * @property string $alternativeText
 * @property string $pageUrl
 * @property string $aNewWindow
 */
class ImageLinkObject extends Entity
{
    #region [Properties]
    public $id;
    public $name;
    public $illustration;
    public $alternativeText;
    public $pageUrl;
    public $aNewWindow;
    #endregion
}