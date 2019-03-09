<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 12:03
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Params;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;

class RangeParams implements ElasticParamElementInterface
{
    private $type   = null;
    private $field  = null;
    private $params = [];

    public function __construct(string $type, string $field, array $params)
    {
        $this->type   = $type;
        $this->field  = $field;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'range' => [
                $this->type => [
                    $this->field => $this->params,
                ],
            ],
        ];
    }
}
