<?php

namespace App\Infrastructure\Aldo;

class AldoParameters
{
    /**
     * @var string
     */
    private $endpoint = null;
    /**
     * @var string
     */
    private $username = null;
    /**
     * @var string
     */
    private $password = null;

    /**
     * AldoParameters constructor.
     * @param string $endpoint
     * @param string $username
     * @param string $password
     */
    public function __construct(string $endpoint, string $username, string $password)
    {
        $this->endpoint = $endpoint;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
