<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 17:42
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Filters\Interfaces\ElasticFilterInterface;

/**
 * Class MatchPhraseQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MatchPhraseQuery extends BasicQuery implements ElasticFilterInterface
{
    private $field = null;
    private $query = null;

    /**
     * MatchPhraseQuery constructor.
     *
     * @param string $field
     * @param string $query
     */
    public function __construct(string $field, string $query)
    {
        $this->query = $query;
        $this->field = $field;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'match_phrase' => [
                $this->field => array_merge([
                    'query' => $this->query,
                ], $this->additionalParams),
            ],
        ];
    }
}
