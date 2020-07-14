<?php

declare(strict_types=1);

namespace rssBot\services\http;

use GuzzleHttp\Client as GuzzleClient;
use Laminas\Feed\Reader\Http\ClientInterface;
use Laminas\Feed\Reader\Http\Psr7ResponseDecorator;

class Client implements ClientInterface
{
    private GuzzleClient $client;

    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function get($uri)
    {
        $response = $this->client->get($uri);

        return new Psr7ResponseDecorator($response);
    }
}
