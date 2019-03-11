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
 * Class ProductGroupsParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
class ProductGroupsParams implements ElasticParamElementInterface, ElasticParamBuilderInterface
{
    private $values = [];

    /**
     * ProductGroupsParams constructor.
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
            'productGroups' => $this->values,
        ];
    }

    /**
     * @return ElasticBodyElementInterface
     */
    public function createFilter(): ElasticBodyElementInterface
    {
        return new TermsQuery("productGroupsIds", $this->values);
    }
}
