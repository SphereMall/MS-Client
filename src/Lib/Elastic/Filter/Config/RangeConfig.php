<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 11:21
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Config;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticConfigElementInterface;

class RangeConfig implements ElasticConfigElementInterface
{
    private $type   = null;
    private $values = [];

    public function __construct(string $type, array $values)
    {
        $this->type   = $type;
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return [
            'range' => [
                $this->type => $this->values,
            ],
        ];
    }
}
