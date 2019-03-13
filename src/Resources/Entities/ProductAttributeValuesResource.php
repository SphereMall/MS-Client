<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Attribute;
use SphereMall\MS\Resources\Resource;

/**
 * Class ProductAttributeValuesResource
 * @package SphereMall\MS\Resources\Entities
 * @method Attribute get(int $id)
 * @method Attribute first()
 * @method Attribute[] all()
 * @method Attribute update($id, $data)
 * @method Attribute create($data)
 */
class ProductAttributeValuesResource extends Resource
{
    public function getURI()
    {
        return "productattributevalues";
    }

}
