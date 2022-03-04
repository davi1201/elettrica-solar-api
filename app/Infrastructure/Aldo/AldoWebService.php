<?php

namespace App\Infrastructure\Aldo;

use App\Exceptions\AldoException;
use App\Infrastructure\Aldo\Client\XmlFetcher;
use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use XMLReader;

class AldoWebService
{
    /**
     * @var XmlFetcher
     */
    private $fetcher;

    /**
     * @param XmlFetcher $fetcher
     */
    public function __construct(XmlFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @return XMLReader
     */
    public function get(): XMLReader
    {
        try {
            $path = $this->request();
            $reader = $this->parse($path);

            return $reader;
        } catch (AldoException $e) {
            Log::error($e->getMessage());
            Log::error('[aldo_webservice] failed to fetch Webservice data');
            throw $e;
        }
    }

    /**
     * Perform request to Aldo Webservice
     * @throws AldoException
     */
    public function request()
    {
        $xml = $this->fetcher->fetch();
        // Store xml into cloud disk so we can track changes and debug import
        $path = $this->storage()->putFile('aldo', new File($xml));
        $this->fetcher->clear($xml);
        return $this->storage()->path($path);
    }

    /**
     * @param string $file
     * @return XMLReader
     * @throws Throwable
     */
    public function parse(string $file): XMLReader
    {
        $reader = new XMLReader();
        $result = $reader->open($file);

        throw_if($result === false, new AldoException('Error when open XML file'));

        return $reader;
    }

    private function storage(): FilesystemAdapter
    {
        return Storage::disk('local');
    }
}
