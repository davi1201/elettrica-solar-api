<?php

namespace App\Infrastructure\Aldo;

use SimpleXMLElement;
use XMLReader;

class AldoProducts
{
    const NODE_TYPE_PRODUCT = 'produto';

    /**
     * @var AldoWebService
     */
    protected $aldoWebService;
    /**
     * @var XMLReader
     */
    protected $xmlReader;

    /**
     * ImporterManager constructor.
     * @param AldoWebService $aldoWebService
     */
    public function __construct(AldoWebService $aldoWebService)
    {
        $this->aldoWebService = $aldoWebService;
    }

    public function get()
    {
        $xml = $this->aldoWebService->get();
        $this->xmlReader = $xml;
    }

    public function parse($callback)
    {
        $reader = $this->xmlReader;

        while ($reader->read()) {
            if ($this->isValidToExtract($reader) === false) {
                continue;
            }

            $xml = new SimpleXMLElement($reader->readOuterXml());
            $attrs = (array)$xml;
            $data = $attrs;

            try {
                $innerData = (array)$data['atributos'];
            } catch (\Throwable $t) {
                $innerData = [];
            }
            call_user_func($callback, $data, $innerData);
        }
    }

    /**
     * @param XMLReader $reader
     * @return bool
     */
    public function isValidToExtract(XMLReader $reader): bool
    {
        return $reader->nodeType == XMLReader::ELEMENT &&
            $reader->name === self::NODE_TYPE_PRODUCT;
    }
}
