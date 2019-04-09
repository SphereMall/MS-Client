<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11.03.2019
 * Time: 11:50
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Attribute;
use SphereMall\MS\Entities\AttributeValue;
use SphereMall\MS\Entities\EntityGroup;
use SphereMall\MS\Entities\Media;

/**
 * Class EntityGroupsMapper
 *
 * @package SphereMall\MS\Lib\Mappers
 *
 * @property EntityGroup $entityGroup
 * @property array       $data
 */
class EntityGroupsMapper extends Mapper
{
    private $data        = [];
    private $entityGroup = null;

    /**
     * @param array $array
     *
     * @return mixed
     */
    protected function doCreateObject(array $array)
    {
        $this->data        = $array;
        $this->entityGroup = new EntityGroup($this->data);
        $this->setMedia()
             ->setAttributes();

        return $this->entityGroup;
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
                if (!$this->entityGroup->mainMedia) {
                    $this->entityGroup->mainMedia = $media;
                }
                $result[$mediaEntity['attributes']['mediaId'] ?? $mediaEntity['mediaId']] = $media;
            }
        }

        $this->entityGroup->media = $result;

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

        $this->entityGroup->attributes = $attributes;

        return $this;
    }
}
