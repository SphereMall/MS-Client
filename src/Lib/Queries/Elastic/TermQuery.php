<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 17:16
 */

namespace SphereMall\MS\Lib\Queries\Elastic;

/**
 * Class TermQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class TermQuery extends TermsQuery
{
    /**
     * TermQuery constructor.
     *
     * @param string $field
     * @param string $values
     */
    public function __construct(string $field, string $values)
    {
        parent::__construct($field, [$values]);
    }
}
