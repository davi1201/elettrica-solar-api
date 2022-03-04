<?php


namespace App\Infrastructure\Aldo\Client;


class FixedXmlResponseClient implements XmlFetcher
{
    public function fetch()
    {
        return storage_path('app/aldo/kbGXBWQEXRWVa8a12AW9qe89WQK4oAKYGlRHTKe1.xml');
    }

    public function clear(string $path): bool
    {
        return true;
    }
}
