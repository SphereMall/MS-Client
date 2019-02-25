<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 16:06
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

/**
 * Class BasicFilter
 *
 * @package SphereMall\MS\Lib\Filters\Elastic
 */
abstract class BasicQuery
{
    protected $additionalParams = [];

    /**
     * @param array $additionalParams
     *
     * @return $this
     */
    public function setAdditionalParams(array $additionalParams)
    {
        $this->additionalParams = $additionalParams;

        return $this;
    }
}
