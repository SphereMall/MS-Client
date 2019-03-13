<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Media;
use SphereMall\MS\Resources\Resource;

/**
 * Class ImagesResource
 * @package SphereMall\MS\Resources\Entities
 * @method Media get(int $id)
 * @method Media first()
 * @method Media[] all()
 * @method Media update($id, $data)
 * @method Media create($data)
 */
class MediaResource extends Resource
{
    public function getURI()
    {
        return "media";
    }

}
