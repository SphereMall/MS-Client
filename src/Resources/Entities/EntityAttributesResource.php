<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\EntityAttribute;
use SphereMall\MS\Resources\Resource;

/**
 * Class EntityAttributesResource
 * @package SphereMall\MS\Resources\Entities
 * @method EntityAttribute get(int $id)
 * @method EntityAttribute first()
 * @method EntityAttribute[] all()
 * @method EntityAttribute update($id, $data)
 * @method EntityAttribute create($data)
 */
class EntityAttributesResource extends Resource
{
    #region [Override methods]
    public function getURI()
    {
        return "entityattributes";
    }
    #endregion

}
