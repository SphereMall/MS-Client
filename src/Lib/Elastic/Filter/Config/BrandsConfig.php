<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 20.11.18
 * Time: 12:32
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Config;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;

/**
 * Class BrandsConfig
 *
 * @package SphereMall\MS\Lib\Filters\Elastic\Config
 */
class BrandsConfig implements ElasticConfigElementInterface
{
    private $use = false;

    /**
     * BrandsConfig constructor.
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
            'brands' => $this->use,
        ];
    }
}
