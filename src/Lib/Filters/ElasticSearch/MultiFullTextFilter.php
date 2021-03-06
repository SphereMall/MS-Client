<?php
/**
 * Created by PhpStorm.
 * User: DmitriyVorobey
 * Date: 19.02.2018
 * Time: 15:43
 */

namespace SphereMall\MS\Lib\Filters\ElasticSearch;

use SphereMall\MS\Lib\FieldsParams\ElasticSearch\FullTextSearchFieldsParams;
use SphereMall\MS\Lib\Filters\Filter;
use SphereMall\MS\Lib\Filters\Interfaces\SearchInterface;

/**
 * Class FullTextFilter
 * @package SphereMall\MS\Lib\Filters\ElasticSearch
 *
 * @property string $keyword
 * @property array $indexes
 * @property array $elements
 */
class MultiFullTextFilter extends Filter
{
    public    $fields;
    protected $keyword;
    protected $index;
    protected $elements;
    protected $offset = 0;
    protected $limit  = 10;

    /**
     * MultiFullTextFilter constructor.
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        parent::__construct();
        $fieldParams = new FullTextSearchFieldsParams(empty($fields) ? [
            'title',
            'shortDescription',
            'fullDescription'
        ] : $fields);
        $this->fields = $fieldParams->getFields();
    }

    /**
     * @param $index
     * @return $this
     */
    public function index($index)
    {
        /** @var ElasticSearchFilterElement $index */
        if (is_object($index)) {
            $this->index = $index->getValues();
        } elseif (is_array($index)) {
            $this->index = [];
            foreach ($index AS $item) {
                $this->index = array_merge($this->index, $item->getValues());
            }
        }

        return $this;
    }

    /**
     * @param string $keyword
     * @return MultiFullTextFilter
     */
    public function keyword(string $keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function elements(array $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Set a limit on the number of resource and offset for skipping the number of resource
     *
     * @param $offset
     * @param $limit
     *
     * @return $this
     */
    public function limit($limit = 10, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     *  Convert the filter object to a string for a URL
     *
     * @return string
     */
    public function __toString()
    {
        if (count($this->index) == 1) {
            $index = json_encode(['index' => $this->index[0]]);
        } else {
            $index = json_encode(['index' => $this->index]);
        }

        if ($this->limit) {
            $set['size'] = $this->limit;
        }

        $set['from'] = $this->offset;

        $set['query'] = [
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'fields' => $this->fields,
                    ],
                ],
            ],
        ];


        if (!empty($this->keyword)) {
            $set['query']['bool']['must']['multi_match']['query'] = $this->keyword;
        }


        if (!empty($this->elements)) {
            foreach ($this->elements as $element) {
                if ($element instanceof SearchInterface) {
                    $set['query']['bool']['filter'][] = $element->getValues();
                }
            }
        }


        $set = json_encode($set);

        return "{$index}\n{$set}\n";
    }
}
