<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 12:03
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Params;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamBuilderInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;
use SphereMall\MS\Lib\Elastic\Queries\RangeQuery;

/**
 * Class RangeParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
class RangeParams extends BasicParams implements ElasticParamElementInterface, ElasticParamBuilderInterface
{
    private $type   = null;
    private $field  = null;
    private $params = [];

    /**
     * RangeParams constructor.
     *
     * @param string      $type
     * @param string      $field
     * @param array       $params
     * @param string|null $operator
     *
     * @throws \Exception
     */
    public function __construct(string $type, string $field, array $params, string $operator = null)
    {
        $this->type   = $type;
        $this->field  = $field;
        $this->params = $params;
        $this->setOperator($operator);
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

    /**
     * @return array
     */
    public function createFilter(): array
    {
        if ($this->type == 'attributes') {
            $field = $this->field . "_attr.attributeValue.int";
        } else {
            $field = $this->field;
        }

        return [
            new RangeQuery($field, $this->params),
            $this->operator,
        ];
    }
}
