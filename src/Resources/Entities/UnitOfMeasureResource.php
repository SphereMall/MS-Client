<?php
/**
 * Created by PhpStorm.
 * User: [Viktor Matushevskyi](mailto:v.matushevskyi@spheremall.com)
 * Date: 17.04.2018
 * Time: 14:35
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\UnitOfMeasure;
use SphereMall\MS\Resources\Resource;

/**
 * Class UnitOfMeasureResource
 * @package SphereMall\MS\Resources\Entities
 * @method UnitOfMeasure get(int $id)
 * @method UnitOfMeasure first()
 * @method UnitOfMeasure[] all()
 * @method UnitOfMeasure update($id, $data)
 * @method UnitOfMeasure create($data)
 */
class UnitOfMeasureResource extends Resource
{
    public function getURI()
    {
        return "unitofmeasure";
    }

}
