<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11.03.2019
 * Time: 09:48
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Attribute;
use SphereMall\MS\Entities\AttributeValue;
use SphereMall\MS\Entities\Categories;
use SphereMall\MS\Entities\Media;

/**
 * Class CategoriesMapper
 *
 * @package SphereMall\MS\Lib\Mappers
 *
 * @property Categories $category
 * @property array      $data
 */
class CategoriesMapper extends Mapper
{
    private $data     = [];
    private $category = null;

    /**
     * @param array $array
     *
     * @return Categories
     */
    protected function doCreateObject(array $array)
    {
        $this->data     = $array;
        $this->category = new Categories($this->data);
        $this->setMedia()
             ->setAttributes();

        return $this->category;
    }

    /**
     * @return $this
     */
    private function setMedia()
    {
        $result = [];
        if (isset($this->data['mediaEntities'])) {
            foreach ($this->data['mediaEntities'] ?? [] as $mediaEntity) {

                if (isset($mediaEntity['relationships']['media'][0]['attributes'])) {
                    $mediaData = array_merge($mediaEntity['relationships']['media'][0]['attributes'], $mediaEntity['attributes']);
                } else {
                    $mediaData = array_merge($this->data['media'][$mediaEntity['mediaId']], $mediaEntity);
                }
                $media = new Media($mediaData);
                if (!$this->category->mainMedia) {
                    $this->category->mainMedia = $media;
                }
                $result[$mediaEntity['attributes']['mediaId'] ?? $mediaEntity['mediaId']] = $media;
            }
        }

        $this->category->media = $result;

        return $this;
    }

    /**
     * @return $this
     */
    private function setAttributes()
    {
        $attributes = [];
        foreach ($this->data['attributeValues'] ?? [] as $av) {
            $attributeId = $av['attributes']['attributeId'] ?? $av['attributeId'];
            if (!isset($attributes[$attributeId])) {
                $attribute                = $av['relationships']['attributes'][0]['attributes'] ?? $this->data['attributes'][$attributeId];
                $attributes[$attributeId] = new Attribute($attribute);
            }
            $attributeValue                              = isset($av['attributes']) && is_array($av['attributes']) ? $av['attributes'] : $av;
            $attributes[$attributeId]->values[$av['id']] = new AttributeValue($attributeValue);
        }

        $this->category->attributes = $attributes;

        return $this;
    }
}
