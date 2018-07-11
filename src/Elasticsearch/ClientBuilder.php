<?php

namespace SphereMall\MS\Elasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector;
use Elasticsearch\ConnectionPool\StaticNoPingConnectionPool;
use Elasticsearch\Connections\ConnectionFactory;
use Elasticsearch\Transport;
use Psr\Log\NullLogger;

/**
 * Class ClientBuilder
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Common\Exceptions
 * @author   Zachary Tong <zach@elastic.co>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elastic.co
 */
class ClientBuilder extends \Elasticsearch\ClientBuilder
{

    /** @var bool */
    public $multi = false;

    /** @var Transport */
    private $transport;

    /** @var callback */
    private $endpoint;

    /** @var NamespaceBuilderInterface[] */
    private $registeredNamespacesBuilders = [];

    /** @var  ConnectionFactoryInterface */
    private $connectionFactory;

    private $handler;

    /** @var  LoggerInterface */
    private $logger;

    /** @var  LoggerInterface */
    private $tracer;

    /** @var string */
    private $connectionPool = '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool';

    /** @var  string */
    private $serializer = '\Elasticsearch\Serializers\SmartSerializer';

    /** @var  string */
    private $selector = '\Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector';

    /** @var  array */
    private $connectionPoolArgs = [
        'randomizeHosts' => true
    ];

    /** @var array */
    public $hosts;

    /** @var array */
    private $connectionParams;

    /** @var  int */
    private $retries;

    /** @var bool */
    private $sniffOnStart = false;

    /** @var null|array */
    private $sslCert = null;

    /** @var null|array */
    private $sslKey = null;

    /** @var null|bool|string */
    private $sslVerification = null;


    public function setSerializer($serializer)
    {
        $this->parseStringOrObject($serializer, $this->serializer, 'SerializerInterface');

        return $this;
    }

    private function parseStringOrObject($arg, &$destination, $interface)
    {
        if (is_string($arg)) {
            $destination = new $arg;
        } elseif (is_object($arg)) {
            $destination = $arg;
        } else {
            throw new InvalidArgumentException("Serializer must be a class path or instantiated object implementing $interface");
        }
    }


    public function build()
    {
        $this->buildLoggers();

        if (is_null($this->handler)) {
            $this->handler = ClientBuilder::defaultHandler();
        }

        $sslOptions = null;
        if (isset($this->sslKey)) {
            $sslOptions['ssl_key'] = $this->sslKey;
        }
        if (isset($this->sslCert)) {
            $sslOptions['cert'] = $this->sslCert;
        }
        if (isset($this->sslVerification)) {
            $sslOptions['verify'] = $this->sslVerification;
        }

        if (!is_null($sslOptions)) {
            $sslHandler = function (callable $handler, array $sslOptions) {
                return function (array $request) use ($handler, $sslOptions) {
                    // Add our custom headers
                    foreach ($sslOptions as $key => $value) {
                        $request['client'][$key] = $value;
                    }

                    // Send the request using the handler and return the response.
                    return $handler($request);
                };
            };
            $this->handler = $sslHandler($this->handler, $sslOptions);
        }

        if (is_null($this->serializer)) {
            $this->serializer = new SmartSerializer();
        } elseif (is_string($this->serializer)) {
            $this->serializer = new $this->serializer;
        }

        if (is_null($this->connectionFactory)) {
            if (is_null($this->connectionParams)) {
                $this->connectionParams = [];
            }

            // Make sure we are setting Content-Type and Accept (unless the user has explicitly
            // overridden it
            if (isset($this->connectionParams['client']['headers']) === false) {
                $this->connectionParams['client']['headers'] = [
                    'Content-Type' => ['application/json'],
                    'Accept' => ['application/json']
                ];
            } else {
                if (isset($this->connectionParams['client']['headers']['Content-Type']) === false) {
                    $this->connectionParams['client']['headers']['Content-Type'] = ['application/json'];
                }
                if (isset($this->connectionParams['client']['headers']['Accept']) === false) {
                    $this->connectionParams['client']['headers']['Accept'] = ['application/json'];
                }
            }

            $this->connectionFactory = new ConnectionFactory($this->handler, $this->connectionParams, $this->serializer, $this->logger, $this->tracer);
        }

        if (is_null($this->hosts)) {
            $this->hosts = $this->getDefaultHost();
        }

        if (is_null($this->selector)) {
            $this->selector = new RoundRobinSelector();
        } elseif (is_string($this->selector)) {
            $this->selector = new $this->selector;
        }

        $this->buildTransport();

        if (is_null($this->endpoint)) {
            $serializer = $this->serializer;

            $this->endpoint = function ($class) use ($serializer) {
                $fullPath = '\\SphereMall\\MS\Elasticsearch\\Endpoints\\' . $class;
                if (in_array($class, ['Bulk', 'Msearch', 'MsearchTemplate', 'MPercolate'])) {
                    return new $fullPath($serializer);
                } else {
                    return new $fullPath($this->multi);
                }
            };
        }

        $registeredNamespaces = [];
        foreach ($this->registeredNamespacesBuilders as $builder) {
            /** @var $builder NamespaceBuilderInterface */
            $registeredNamespaces[$builder->getName()] = $builder->getObject($this->transport, $this->serializer);
        }

        return $this->instantiate($this->transport, $this->endpoint, $registeredNamespaces);
    }

    protected function instantiate(Transport $transport, callable $endpoint, array $registeredNamespaces)
    {
        return new Client($transport, $endpoint, $registeredNamespaces);
    }


    /**
     * @return array
     */
    private function getDefaultHost()
    {
        return ['localhost:9200'];
    }


    private function buildLoggers()
    {
        if (is_null($this->logger)) {
            $this->logger = new NullLogger();
        }

        if (is_null($this->tracer)) {
            $this->tracer = new NullLogger();
        }
    }

    private function buildTransport()
    {
        $connections = $this->buildConnectionsFromHosts($this->hosts);

        if (is_string($this->connectionPool)) {
            $this->connectionPool = new $this->connectionPool(
                $connections,
                $this->selector,
                $this->connectionFactory,
                $this->connectionPoolArgs
            );
        } elseif (is_null($this->connectionPool)) {
            $this->connectionPool = new StaticNoPingConnectionPool(
                $connections,
                $this->selector,
                $this->connectionFactory,
                $this->connectionPoolArgs
            );
        }

        if (is_null($this->retries)) {
            $this->retries = count($connections);
        }

        if (is_null($this->transport)) {
            $this->transport = new Transport($this->retries, $this->sniffOnStart, $this->connectionPool, $this->logger);
        }
    }

    /**
     * @param array $hosts
     *
     * @throws \InvalidArgumentException
     * @return \Elasticsearch\Connections\Connection[]
     */
    private function buildConnectionsFromHosts($hosts)
    {
        if (is_array($hosts) === false) {
            $this->logger->error("Hosts parameter must be an array of strings, or an array of Connection hashes.");
            throw new InvalidArgumentException('Hosts parameter must be an array of strings, or an array of Connection hashes.');
        }

        $connections = [];
        foreach ($hosts as $host) {
            if (is_string($host)) {
                $host = $this->prependMissingScheme($host);
                $host = $this->extractURIParts($host);
            } elseif (is_array($host)) {
                $host = $this->normalizeExtendedHost($host);
            } else {
                $this->logger->error("Could not parse host: ".print_r($host, true));
                throw new RuntimeException("Could not parse host: ".print_r($host, true));
            }
            $connections[] = $this->connectionFactory->create($host);
        }

        return $connections;
    }

    /**
     * @param string $host
     *
     * @return string
     */
    private function prependMissingScheme($host)
    {
        if (!filter_var($host, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)) {
            $host = 'http://' . $host;
        }

        return $host;
    }


    /**
     * @param array $host
     *
     * @throws \InvalidArgumentException
     * @return array
     */
    private function extractURIParts($host)
    {
        $parts = parse_url($host);

        if ($parts === false) {
            throw new InvalidArgumentException("Could not parse URI");
        }

        if (isset($parts['port']) !== true) {
            $parts['port'] = 9200;
        }

        return $parts;
    }

    /**
     * @param $host
     * @return array
     */
    private function normalizeExtendedHost($host)
    {
        if (isset($host['host']) === false) {
            $this->logger->error("Required 'host' was not defined in extended format: ".print_r($host, true));
            throw new RuntimeException("Required 'host' was not defined in extended format: ".print_r($host, true));
        }

        if (isset($host['scheme']) === false) {
            $host['scheme'] = 'http';
        }
        if (isset($host['port']) === false) {
            $host['port'] = '9200';
        }
        return $host;
    }

    /**
     * @param array $hosts
     * @return $this
     */
    public function setHosts($hosts)
    {
        $this->hosts = $hosts;

        return $this;
    }
}
