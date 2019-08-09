<?php
namespace SphereMall\MS\Lib\Http;

/**
 * Class LayoutObjectsRequest
 * @package SphereMall\MS\Lib\Http
 */
class LayoutObjectsRequest extends Request
{
    public function post(&$options, array $body = [])
    {
        $options['headers']['Content-Type'] = 'application/json';
        $options['body'] = json_encode($body);
    }

    public function put(&$options, array $body = [])
    {
        $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        $options['body'] = json_encode($body);
    }
}
