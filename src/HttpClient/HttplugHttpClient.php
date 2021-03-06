<?php declare(strict_types=1);

namespace Vantoozz\ProxyScraper\HttpClient;

use Exception;
use Http\Client\Exception as ClientException;
use Http\Client\HttpClient as Client;
use Http\Message\MessageFactory;
use Vantoozz\ProxyScraper\Exceptions\HttpClientException;

/**
 * Class HttplugHttpClient
 * @package Vantoozz\ProxyScraper\HttpClient
 * @deprecated Use Psr18HttpClient instead
 */
final class HttplugHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * HttplugHttpClient constructor.
     * @param Client $httpClient
     * @param MessageFactory $messageFactory
     */
    public function __construct(Client $httpClient, MessageFactory $messageFactory)
    {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string $uri
     * @return string
     * @throws HttpClientException
     */
    public function get(string $uri): string
    {
        $request = $this->messageFactory->createRequest('GET', $uri);
        try {
            return $this->httpClient->sendRequest($request)->getBody()->getContents();
        } catch (ClientException | Exception $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
