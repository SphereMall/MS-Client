<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Products;

use SphereMall\MS\Entities\AttributeValue;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributeValuesResource
 * @package SphereMall\MS\Resources\Products
 * @method AttributeValue get(int $id)
 * @method AttributeValue[] all()
 * @method AttributeValue update()
 * @method AttributeValue create()
 */
class AttributeValuesResource extends Resource
{
    public function getURI()
    {
        return "attributevalues";
    }

}