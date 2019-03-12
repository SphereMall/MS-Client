<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/22/2017
 * Time: 7:36 PM
 */

namespace SphereMall\MS\Lib\Mappers;

/**
 * Class ProductAttributeValuesMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class ProductAttributeValuesMapper extends Mapper
{
    #region [Protected methods]
    /**
     * @param array $array
     * @return array
     */
    protected function doCreateObject(array $array)
    {
        $raw = [];
        foreach ($array as $item) {
            $raw[$item['attributeId']]['id'] = $item['attributeId'];
            $raw[$item['attributeId']]['title'] = $item['title'];
            $raw[$item['attributeId']]['code'] = $item['code'];
            $raw[$item['attributeId']]['showInSpecList'] = $item['showInSpecList'];
            $raw[$item['attributeId']]['description'] = $item['description'];
            $raw[$item['attributeId']]['attributeGroupId'] = $item['attributeGroupId'];
            $raw[$item['attributeId']]['cssClass'] = $item['cssClass'];
            $raw[$item['attributeId']]['orderNumber'] = $item['orderNumber'];
            $raw[$item['attributeId']]['schemaOrgProperty'] = $item['schemaOrgProperty'] ?? null;
            $raw[$item['attributeId']]['attributeTypeId'] = $item['attributeTypeId'] ?? null;

            $raw[$item['attributeId']]['attributeValues'][] = [
                'id'              => $item['id'],
                'value'           => $item['value'],
                'title'           => $item['valueTitle'],
                'image'           => $item['image'],
                'cssClass'        => $item['valueCssClass'],
                'unitOfMeasureId' => $item['unitOfMeasureId'],
                'orderNumber'     => $item['valueOrderNumber']
            ];
        }

        $mapper = new AttributesMapper();
        $result = [];
        foreach ($raw as $item) {
            $result[] = $mapper->createObject($item);
        }

        return $result;
    }
    #endregion
}