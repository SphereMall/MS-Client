<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\SMEntity;
use SphereMall\MS\Resources\Resource;

/**
 * Class EntitiesResource
 * @package SphereMall\MS\Resources\Entities
 * @method SMEntity get(int $id)
 * @method SMEntity first()
 * @method SMEntity[] all()
 * @method SMEntity update($id, $data)
 * @method SMEntity create($data)
 */
class EntitiesResource extends Resource
{
    #region [Override methods]
    public function getURI()
    {
        return "entities";
    }
    #endregion

}
