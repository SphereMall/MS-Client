<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 9:36
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Params;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamBuilderInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;

/**
 * Class AttributesParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
class AttributesParams implements ElasticParamElementInterface, ElasticParamBuilderInterface
{
    private $code   = null;
    private $values = [];

    /**
     * AttributesParams constructor.
     *
     * @param       $code
     * @param array $values
     */
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

    /**
     * @return ElasticBodyElementInterface
     */
    public function createFilter(): ElasticBodyElementInterface
    {
        return new TermsQuery($this->code . "_attr.valueId", $this->values);

    }
}
