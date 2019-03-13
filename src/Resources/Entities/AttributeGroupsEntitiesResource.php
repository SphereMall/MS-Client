<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\AttributeGroupsEntities;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributeGroupsEntitiesResource
 * @package SphereMall\MS\Resources\Entities
 * @method AttributeGroupsEntities get(int $id)
 * @method AttributeGroupsEntities first()
 * @method AttributeGroupsEntities[] all()
 * @method AttributeGroupsEntities update($id, $data)
 * @method AttributeGroupsEntities create($data)
 */
class AttributeGroupsEntitiesResource extends Resource
{
    public function getURI()
    {
        return "attributegroupsentities";
    }

}
