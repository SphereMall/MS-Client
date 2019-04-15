<?php


namespace SphereMall\MS\Lib\Elastic\Filter\Params;

use Exception;
use SphereMall\MS\Lib\Filters\FilterOperators;

/**
 * Class BasicParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
abstract class BasicParams
{
    const DEFAULT_OPERATOR    = FilterOperators::IN;
    const SUPPORTED_OPERATORS = [
        FilterOperators::IN,
        FilterOperators::NOT_IN,
    ];

    protected $operator = null;

    /**
     * @param string $operator
     *
     * @return bool
     * @throws Exception
     */
    protected function setOperator(?string $operator): bool
    {
        if (!$operator) {
            $this->operator = self::DEFAULT_OPERATOR;

            return true;
        }

        if (in_array($operator, self::SUPPORTED_OPERATORS)) {
            $this->operator = $operator;

            return true;
        }

        throw new Exception("Not supported operator");
    }
}
