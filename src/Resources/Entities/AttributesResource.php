<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Attribute;
use SphereMall\MS\Resources\Resource;

/**
 * Class AttributesResource
 * @package SphereMall\MS\Resources\Entities
 * @method Attribute get(int $id)
 * @method Attribute first()
 * @method Attribute[] all()
 * @method Attribute update($id, $data)
 * @method Attribute create($data)
 */
class AttributesResource extends Resource
{
    public function getURI()
    {
        return "attributes";
    }

    /**
     * @param string $entityClass class name like Entity::class
     * @param int|null $attributeGroupId
     * @param int|null $attributeId
     *
     * @return array|\SphereMall\MS\Lib\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function belong(string $entityClass, int $attributeGroupId = null, int $attributeId = null)
    {
        $uriAppend = '/belong/' . strtolower((new \ReflectionClass($entityClass))->getShortName()) . "s";
        $params    = $this->getQueryParams();
        if (!is_null($attributeGroupId)) {
            $uriAppend .= "/$attributeGroupId";
            if (!is_null($attributeId)) {
                $uriAppend .= "/$attributeId";
            }
        }

        $response = $this->handler->handle('GET', false, $uriAppend, $params);

        return $this->make($response);
    }
}
