<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\CatalogItem;
use SphereMall\MS\Resources\Resource;

/**
 * Class CatalogItemsResource
 * @package SphereMall\MS\Resources\Entities
 * @method CatalogItem get(int $id)
 * @method CatalogItem first()
 * @method CatalogItem[] all()
 * @method CatalogItem update($id, $data)
 * @method CatalogItem create($data)
 */
class CatalogItemsResource extends Resource
{
    public function getURI()
    {
        return "catalogitems";
    }

}
