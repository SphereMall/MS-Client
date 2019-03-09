<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 20.11.18
 * Time: 13:40
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Config;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;

/**
 * Class AttributesConfig
 *
 * @package SphereMall\MS\Lib\Filters\Elastic\Config
 */
class AttributesConfig implements ElasticConfigElementInterface
{
    private $attributes = [];

    /**
     * AttributesConfig constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->setAttributeItem($attribute);
        }
    }

    /**
     * @return mixed
     */
    public function getElements(): array
    {
        return [
            'attributes' => $this->attributes,
        ];
    }

    /**
     * @param string $attribute
     *
     * @return $this
     */
    private function setAttributeItem(string $attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }
}
