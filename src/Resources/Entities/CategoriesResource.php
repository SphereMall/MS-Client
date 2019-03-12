<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08.03.2019
 * Time: 14:56
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Categories;
use SphereMall\MS\Resources\Resource;
use SphereMall\MS\Resources\Traits\DetailResource;

/**
 * Class CategoriesResource
 *
 * @package SphereMall\MS\Resources\Entities
 * @method Categories get(int $id)
 * @method Categories first()
 * @method Categories[] all()
 * @method Categories update($id, $data)
 * @method Categories create($data)
 * @method Categories|Categories[] detail($param = null)
 * @method Categories[] detailAll()
 * @method Categories detailById(int $id)
 * @method Categories detailByCode(string $code)
 */
class CategoriesResource extends Resource
{
    use DetailResource;

    function getURI()
    {
        return "categories";
    }
}
