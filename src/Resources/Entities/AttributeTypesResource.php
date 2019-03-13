<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\AttributeType;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributeTypesResource
 * @package SphereMall\MS\Resources\Entities
 * @method AttributeType get(int $id)
 * @method AttributeType first()
 * @method AttributeType[] all()
 * @method AttributeType update($id, $data)
 * @method AttributeType create($data)
 */
class AttributeTypesResource extends Resource
{
    public function getURI()
    {
        return "attributetypes";
    }

}
