<?php declare(strict_types=1);

namespace Fop\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

final class RequestClient
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed[]
     */
    public function requestToJson(string $url): array
    {
        $request = new Request('GET', $url);
        $response = $this->client->send($request);

        // unable to resolve country
        if ($response->getStatusCode() !== 200) {
            throw BadResponseException::create($request, $response);
        }

        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }

        try {
            return Json::decode((string) $response->getBody(), Json::FORCE_ARRAY);
        } catch (JsonException $jsonException) {
            throw new JsonException('Syntax error while decoding:' . (string) $response->getBody());
        }
    }
}