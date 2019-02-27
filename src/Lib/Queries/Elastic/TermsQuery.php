<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 16:51
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticQueryInterface;

/**
 * Class TermsQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class TermsQuery extends BasicQuery implements ElasticQueryInterface
{

    private $field  = null;
    private $values = [];

    /**
     * TermsQuery constructor.
     *
     * @param string $field
     * @param array  $values
     */
    public function __construct(string $field, array $values)
    {
        $this->field  = $field;
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'terms' => [
                $this->field => $this->values,
            ],
        ];
    }
}
