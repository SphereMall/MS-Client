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
 * Class FunctionalNamesConfig
 *
 * @package SphereMall\MS\Lib\Filters\Elastic\Config
 */
class FunctionalNamesConfig implements ElasticConfigElementInterface
{
    private $use = false;

    /**
     * FunctionalNamesConfig constructor.
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
            'functionalNames' => $this->use,
        ];
    }
}
