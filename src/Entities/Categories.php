<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08.03.2019
 * Time: 15:01
 */

namespace SphereMall\MS\Entities;

use SphereMall\MS\Lib\Traits\InteractsWithAttributes;
use SphereMall\MS\Lib\Traits\InteractsWithMedia;

/**
 * Class Categories
 *
 * @package SphereMall\MS\Entities
 * @property int    $id
 * @property string $urlCode
 * @property string $title
 * @property int    $visible
 * @property int    $orderNumber
 * @property string $lastUpdate
 * @property string $createDate
 */
class Categories extends Entity
{
    use InteractsWithAttributes;
    use InteractsWithMedia;

    public $id;
    public $urlCode;
    public $title;
    public $visible;
    public $orderNumber;
    public $lastUpdate;
    public $createDate;

    public $media;
    public $mainMedia;

    public $attributes;
}
