<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:51
 */

namespace SphereMall\MS\Lib\Http\ElasticSearch;


use SphereMall\MS\Lib\Http\Meta;

class Response extends \SphereMall\MS\Lib\Http\Response
{
    public function __construct(array $response, $limit = 0, $offset = 0)
    {
        $this->statusCode = (!$response['timed_out'] ? 200 : 404);
        $this->headers = [];

        try {
            $this->data = $responses ?? $response;
            $this->status = !$response['timed_out'] ? 'OK' : 'ERROR';
            $this->errors = $response['error'] ?? null;
            $this->debug = $contents['debug'] ?? null;
            $this->version = 1;
            $this->included = [];
            $this->meta = new Meta($this->data['hits']['total'] ?? 0, $limit, $offset);
        } catch (\Exception $ex) {
            $this->success = false;
            $this->errors = $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }
    }
}
