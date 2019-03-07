<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 20.11.18
 * Time: 19:45
 */

namespace SphereMall\MS\Lib\Filters\Elastic\Config;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;
use SphereMall\MS\Lib\Filters\Interfaces\ElasticConfigInterface;

/**
 * Class ConfigBuilder
 *
 * @package SphereMall\MS\Lib\Filters\Elastic\Config
 */
class ConfigBuilder implements ElasticConfigInterface
{
    private $config = [];

    /**
     * ConfigBuilder constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        foreach ($configs as $configItem) {
            $this->setConfig($configItem);
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ElasticConfigElementInterface $config
     */
    public function setConfig(ElasticConfigElementInterface $config)
    {
        $this->config += $config->getElements();
    }
}
