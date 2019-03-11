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
 * Class FunctionalNamesParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
class FunctionalNamesParams implements ElasticParamElementInterface, ElasticParamBuilderInterface
{
    private $values = [];

    /**
     * FunctionalNamesParams constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'functionalNames' => $this->values,
        ];
    }

    /**
     * @return ElasticBodyElementInterface
     */
    public function createFilter(): ElasticBodyElementInterface
    {
        return new TermsQuery("functionalNameId", $this->values);
    }
}
