<?php

namespace App\Infrastructure\Aldo\Client;

use App\Exceptions\AldoException;
use App\Infrastructure\Aldo\AldoParameters;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AldoClient implements XmlFetcher
{
    /**
     * @var AldoParameters
     */
    protected $config;
    /**
     * @var Client
     */
    protected $client;

    /**
     * AldoClient constructor.
     * @param AldoParameters $config
     * @param Client $client
     */
    public function __construct(AldoParameters $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    public function fetch()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'aldo');
        $tmpFile = fopen($tempnam, 'w+');
        $this->client = new Client([
                'verify' => false
        ]);

        try {
            $this->client->get($this->config->getEndpoint(), [
                'query' => [
                    'u' => $this->config->getUsername(),
                    'p' => $this->config->getPassword(),
                ],
                'sink' => $tmpFile
            ]);


            $this->replaceEncoding($tempnam);
        } catch (RequestException $e) {
            fclose($tmpFile);

            if ($e->hasResponse() === false) {
                throw new AldoException(sprintf('Failed to perform request to Aldo Webservice "%s"',
                    \GuzzleHttp\Psr7\str($e->getRequest())));
            }

            throw new AldoException(sprintf('An error occurs while fetch data from webservice "%s"',
                \GuzzleHttp\Psr7\str($e->getResponse())));
        }

        return $tempnam;
    }

    private function replaceEncoding($path) {
        $reading = fopen($path, 'r');
        $tempnam = tempnam(sys_get_temp_dir(), 'aldoutf8');
        $writing = fopen($tempnam, 'w');

        while (!feof($reading)) {
            $line = fgets($reading);
            $line=str_replace('iso-8859-1', 'utf-8', $line);
            fputs($writing, $line);
        }
        fclose($reading);
        fclose($writing);
        // might as well not overwrite the file if we didn't replace anything
        rename($tempnam, $path);
        //$content = file_get_contents($path);
        //$content = str_replace('iso-8859-1', 'utf-8', $content);
        //file_put_contents($path, $content);
    }

    public function clear(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        if (!is_writable($path)) {
            return false;
        }

        unlink($path);
        return true;
    }
}
