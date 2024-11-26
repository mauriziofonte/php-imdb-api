<?php
namespace Mfonte\ImdbScraper;

use PHPHtmlParser\Dom as PHPHtmlParserDom;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

/**
*  Class Dom
*
*
* @package mfonte/imdb-scraper
* @author Harry Merritt
*/
class Dom
{

    /**
     * Fetch and parse the DOM of a remote site
     *
     * @param string $url
     *
     * @return \PHPHtmlParser\Dom
     */
    public function fetch(string $url, array $options = [], bool $log = false)
    {
        $dom = new PHPHtmlParserDom;

        $headers = (isset($options['curlHeaders'])) ? $options['curlHeaders'] : [
            'Accept-Language: en-US,en;q=0.5',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
        ];

        $clientOpts = [
            'allow_redirects' => [
                'max'       => 10,    // Maximum number of redirects
                'strict'    => false, // Use relaxed HTTP RFC compliance
                'referer'   => true,  // Add a Referer header when redirecting
                'protocols' => ['http', 'https'], // Follow only these protocols
            ],
            'headers' => ['User-Agent' => null],
        ];

        if ($log) {
            // Create a Monolog logger instance
            $logger = new Logger('http_logger');
            $logger->pushHandler(new StreamHandler('php://stdout', Level::Debug));

            // Set up Guzzle handler stack with logging middleware
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter(MessageFormatter::DEBUG) // Logs detailed request/response info
                )
            );

            // Create a Guzzle client with the handler stack
            $client = new Client(array_merge($clientOpts, ['handler' => $stack]));
        } else {
            // Create a Guzzle client (implements ClientInterface)
            $client = new Client($clientOpts);
        }

        // Add custom headers to the request
        $request = new Request('GET', $url, $headers);

        // Load the URL with the custom client and request
        $dom->loadFromUrl($url, null, $client, $request);

        return $dom;
    }

    /**
     * Find object within DOM (if it exists) and reutrn an attribute
     *
     * @param object $dom
     * @param string $selection
     *
     * @return array|object
     */
    public function find(object $dom, string $selection)
    {
        $found = $dom->find($selection);
        if (count($found) > 0) {
            return $found;
        } else {
            return $this->emptyElement();
        }
    }

    /**
     * Create and parse an empty html string as a DOM element
     *
     * @return \PHPHtmlParser\Dom
     */
    private function emptyElement()
    {
        $dom = new \PHPHtmlParser\Dom;
        $dom->loadStr('<a emptyElement="true" src="" href="" data-video=""></a>');
        return $dom;
    }

}
