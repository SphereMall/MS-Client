<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\AttributeValue;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributeValuesResource
 * @package SphereMall\MS\Resources\Entities
 * @method AttributeValue get(int $id)
 * @method AttributeValue first()
 * @method AttributeValue[] all()
 * @method AttributeValue update($id, $data)
 * @method AttributeValue create($data)
 */
class AttributeValuesResource extends Resource
{
    public function getURI()
    {
        return "attributevalues";
    }

}
