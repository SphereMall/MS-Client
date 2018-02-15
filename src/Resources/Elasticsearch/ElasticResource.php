<?php
/**
 * Created by PhpStorm.
 * User: DmitriyVorobey
 * Date: 15.02.2018
 * Time: 13:36
 */

namespace SphereMall\MS\Resources\Elasticsearch;

use SphereMall\MS\Resources\Resource;

/**
 * Class ElasticResource
 * @package SphereMall\MS\Resources\Elasticsearch
 */
abstract class ElasticResource extends Resource
{
    protected $params = [
        'index' => 'sm-products-test',
        'body'  => ['query' => ['match_all' => []]],
    ];

    #region [Protected methods]

    /**
     * @return array|mixed
     */
    protected function getQueryParams()
    {
        $params = parent::getQueryParams();

        if (empty($params['keyword'])) {
            return $params;
        }

        $params['body']['query'] = ['query_string' => ['query' => 'Test']];
        if (!empty($params['offset'])) {
            $this->params['body'] = ['from' => $params['offset']];
        }
        if (!empty($params['limit'])) {
            $this->params['body'] = ['size' => $params['offset']];
        }
        if (!empty($params['filter'])) {
            $sort = [];
            foreach ($params['filter'] as $field => $type) {
                $sort[$field] = ['order' => $type];
            }
            if (sizeof($sort) > 0) {
                $this->params['sort'] = $sort;
            }
        }

        return $params;
    }
    #endregion
}
