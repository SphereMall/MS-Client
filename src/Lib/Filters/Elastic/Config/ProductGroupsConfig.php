<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 11.12.18
 * Time: 17:05
 */

namespace SphereMall\MS\Lib\Filters\Elastic\Config;


use SphereMall\MS\Lib\Filters\Interfaces\ElasticConfigElementInterface;

class ProductGroupsConfig implements ElasticConfigElementInterface
{
    private $use = false;

    /**
     * PriceRangeConfig constructor.
     *
     * @param bool $use
     */
    public function __construct(bool $use)
    {
        $this->use = $use;
    }

    /**
     * @return mixed
     */
    public function getElements(): array
    {
        return [
            'productGroups' => $this->use,
        ];
    }
}