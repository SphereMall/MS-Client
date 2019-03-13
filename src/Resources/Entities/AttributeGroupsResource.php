<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\AttributeGroup;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributeGroupsResource
 * @package SphereMall\MS\Resources\Entities
 * @method AttributeGroup get(int $id)
 * @method AttributeGroup first()
 * @method AttributeGroup[] all()
 * @method AttributeGroup update($id, $data)
 * @method AttributeGroup create($data)
 */
class AttributeGroupsResource extends Resource
{
    public function getURI()
    {
        return "attributegroups";
    }

}
