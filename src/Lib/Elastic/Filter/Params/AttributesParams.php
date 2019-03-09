<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 9:36
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Params;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;

class AttributesParams implements ElasticParamElementInterface
{
    private $code   = null;
    private $values = [];

    public function __construct($code, array $values)
    {
        $this->code   = $code;
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'attributes' => [
                $this->code => [
                    "id" => $this->values,
                ],
            ],
        ];
    }
}
