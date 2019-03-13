<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Product;
use SphereMall\MS\Entities\ProductVariant;
use SphereMall\MS\Resources\Resource;
use SphereMall\MS\Resources\Traits\DetailResource;
use SphereMall\MS\Resources\Traits\FullResource;
use SphereMall\MS\Resources\Traits\WithActions;

/**
 * Class ProductVariantsResource
 * @package SphereMall\MS\Resources\Entities
 * @method ProductVariant first()
 * @method ProductVariant[] all()
 */
class ProductVariantsResource extends Resource
{
    #region [Override methods]

    /**
     * @return string
     */
    public function getURI()
    {
        return "productvariants";
    }
    #endregiona
}
