<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 24.06.2019
 * Time: 11:04
 */

namespace SphereMall\MS\Lib\Http;


trait RequestMethods
{
    public function get(&$options, array $body = [])
    {
        $options['body'] = json_encode($body);
    }

    public function put(&$options, array $body = [])
    {
        $options['body'] = http_build_query($body);
        $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
    }


    public function post(&$options, array $body = [])
    {
        $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        $options['form_params'] = $body;
    }


    public function delete(&$options, array $body = [])
    {
        $options['body'] = http_build_query($body);
    }

    public function patch(&$options, array $body = [])
    {
        $options['body'] = json_encode($body);
        $options['headers']['Content-Type'] = 'application/json';
    }
}