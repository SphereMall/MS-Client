<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\MediaType;
use SphereMall\MS\Resources\Resource;

/**
 * Class MediaTypesResource
 * @package SphereMall\MS\Resources\Entities
 * @method MediaType get(int $id)
 * @method MediaType first()
 * @method MediaType[] all()
 * @method MediaType update($id, $data)
 * @method MediaType create($data)
 */
class MediaTypesResource extends Resource
{
    public function getURI()
    {
        return "imagetypes";
    }

}
