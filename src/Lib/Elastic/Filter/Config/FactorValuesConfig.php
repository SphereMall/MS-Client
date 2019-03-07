<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 20.11.18
 * Time: 14:58
 */

namespace SphereMall\MS\Lib\Filters\Elastic\Config;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;

/**
 * Class FactorValuesConfig
 *
 * @package SphereMall\MS\Lib\Filters\Elastic\Config
 */
class FactorValuesConfig implements ElasticConfigElementInterface
{
    private $factorValues = [];

    /**
     * FactorValuesConfig constructor.
     *
     * @param array $factorValues
     */
    public function __construct(array $factorValues)
    {
        foreach ($factorValues as $factorValue) {
            $this->setFactorValues($factorValue);
        }
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return [
            'factorValues' => $this->factorValues,
        ];
    }

    /**
     * @param int $factorValue
     *
     * @return $this
     */
    private function setFactorValues(int $factorValue)
    {
        $this->factorValues[] = $factorValue;

        return $this;
    }
}
