<?php

namespace SphereMall\MS\Elasticsearch\Serializers;

use Elasticsearch\Common\Exceptions\RuntimeException;
use Elasticsearch\Serializers\SerializerInterface;

/**
 * Class JSONSerializer
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Serializers\JSONSerializer
 * @author   Zachary Tong <zach@elastic.co>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elastic.co
 */
class MultiJSONSerializer implements SerializerInterface
{
    /**
     * Serialize assoc array into JSON string
     *
     * @param string|array $data Assoc array to encode into JSON
     *
     * @return string
     */
    public function serialize($data)
    {
        if (is_string($data) === true) {
            return $data;
        } else {

            $from = $data['from'] ?? 0;
            unset($data['from']);

            $size = $data['size'] ?? 0;
            unset($data['size']);

            $result = [];
            foreach ($data AS &$item) {
                $item = json_encode($item, JSON_PRESERVE_ZERO_FRACTION);
                if ($item === false) {
                    throw new RuntimeException("Failed to JSON encode: " . json_last_error());
                }

                if ($item === '[]') {
                    $item = '{}';
                }
            }

            return implode("\n", $data) . "\n";
        }
    }

    /**
     * Deserialize JSON into an assoc array
     *
     * @param string $data JSON encoded string
     * @param array $headers Response Headers
     *
     * @return array
     */
    public function deserialize($data, $headers)
    {
        $dataArray = json_decode($data, true);

        $result = [
            'hits'    => [
                'total'     => 0,
                'max_score' => 0,
                'hits'      => [],
            ],
            '_shards' => [
                'total'      => 0,
                'successful' => 0,
                'skipped'    => 0,
                'failed'     => 0,
            ],
        ];
        foreach ($dataArray['responses'] AS $item) {
            $result['took'] = $item['took'];
            $result['timed_out'] = $item['timed_out'];

            $result['_shards']['total'] += $item['_shards']['total'];
            $result['_shards']['successful'] += $item['_shards']['successful'];
            $result['_shards']['skipped'] += $item['_shards']['skipped'];
            $result['_shards']['failed'] += $item['_shards']['failed'];

            $result['hits']['total'] += $item['hits']['total'];
            $result['hits']['max_score'] += $item['hits']['max_score'];
            $result['hits']['hits'] = array_merge($result['hits']['hits'], $item['hits']['hits']);
        }

        return $result;
    }
}
