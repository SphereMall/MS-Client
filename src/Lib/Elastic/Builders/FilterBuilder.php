<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 7:58
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Filter\Config\AttributesConfig;
use SphereMall\MS\Lib\Elastic\Filter\Config\RangeConfig;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;
use SphereMall\MS\Lib\Filters\Filter;

/**
 * Class FilterBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Filter
 */
class FilterBuilder extends Filter
{
    private $configs = [];
    private $query = [];
    private $factors = [];
    private $params = [];

    /**
     * @param array $configs
     *
     * @return $this
     */
    public function setConfigs(array $configs)
    {
        foreach ($configs as $config) {
            $this->setConfig($config);
        }

        return $this;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params = [])
    {
        foreach ($params as $param) {
            $this->setParam($param);
        }

        return $this;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function deleteParams(array $params = [])
    {
        foreach ($params as $param) {
            $this->deleteParam($param);
        }

        return $this;
    }

    /**
     * @param array $entities
     *
     * @return $this
     */
    public function setEntities(array $entities)
    {
        $this->query['entities'] = implode(',', $entities);

        return $this;
    }

    /**
     * @param string $query
     * @param array $fields
     *
     * @return $this
     */
    public function setKeyword(string $query, array $fields)
    {
        $this->query['keyword'] = [
            'fields' => $fields,
            'value'  => $query,
        ];

        return $this;
    }

    /**
     * @param string $groupBy
     *
     * @return $this
     */
    public function setGroupBy(string $groupBy)
    {
        $this->query['groupBy'] = $groupBy;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfigs()
    {
        $elements = [];

        foreach ($this->configs as $config) {
            /**@var ElasticConfigElementInterface $config * */

            $configElements = $config->getElements();

            switch (get_class($config)) {
                case AttributesConfig::class:
                    $configName = key($configElements);
                    if (isset($elements[$configName])) {
                        $elements[$configName][] = $configElements[$configName][0] ?? [];
                    } else {
                        $elements += $configElements;
                    }
                    break;
                case RangeConfig::class:
                    $configName = key($configElements);
                    foreach ($configElements[$configName] ?? [] as $rangeKey => $rangevalue) {
                        if (!isset($elements[$configName][$rangeKey])) {
                            $elements[$configName][$rangeKey] = [];
                        }
                        $elements[$configName][$rangeKey] = array_merge($elements[$configName][$rangeKey], $rangevalue);
                    }
                    break;
                default:
                    $elements += $configElements;
            }
        }

        return $elements;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        $result = $this->query;

        if ($this->params) {
            $result['params'] = [];
            foreach ($this->params as $param) {
                $result['params'] = array_merge_recursive($result['params'], $param->getParams());
            }
            $result['params'] = json_encode([
                $result['params'],
            ]);
        }

        if (isset($result['keyword'])) {
            $result['keyword'] = json_encode($result['keyword']);
        }

        return $result;
    }

    public function setFactors(array $factors)
    {
        $this->factors = $factors;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array_merge($this->query, ['factorValues' => $this->factors], ['params' => $this->params]);
    }

    /**
     * @param ElasticConfigElementInterface $config
     *
     * @return $this
     */
    private function setConfig(ElasticConfigElementInterface $config)
    {
        $this->configs[] = $config;

        return $this;
    }

    /**
     * @param ElasticParamElementInterface $param
     *
     * @return $this
     */
    private function setParam(ElasticParamElementInterface $param)
    {
        $this->params[] = $param;

        return $this;
    }

    /**
     * @param ElasticParamElementInterface $param
     *
     * @return $this
     */
    private function deleteParam(ElasticParamElementInterface $param)
    {
        if (($key = array_search($param, $this->params)) !== false) {
            unset($this->params[$key]);
        }

        return $this;
    }
}
