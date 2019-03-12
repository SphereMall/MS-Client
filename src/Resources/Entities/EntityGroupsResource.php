<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08.03.2019
 * Time: 15:16
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\EntityGroups;
use SphereMall\MS\Resources\Resource;
use SphereMall\MS\Resources\Traits\DetailResource;

/**
 * Class EntityGroupsResource
 *
 * @package SphereMall\MS\Resources\Entities
 * @method EntityGroups get(int $id)
 * @method EntityGroups first()
 * @method EntityGroups[] all()
 * @method EntityGroups update($id, $data)
 * @method EntityGroups create($data)
 * @method EntityGroups|EntityGroups[] detail($param = null)
 * @method EntityGroups[] detailAll()
 * @method EntityGroups detailById(int $id)
 * @method EntityGroups detailByCode(string $code)
 */
class EntityGroupsResource extends Resource
{
    use DetailResource;

    function getURI()
    {
        return "entitygroups";
    }
}
