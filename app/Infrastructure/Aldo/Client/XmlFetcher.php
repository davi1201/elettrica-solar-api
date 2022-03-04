<?php

namespace App\Infrastructure\Aldo\Client;

interface XmlFetcher
{
    public function fetch();

    public function clear(string $path): bool;
}
