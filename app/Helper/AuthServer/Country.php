<?php

namespace App\Helper\AuthServer;

class Country extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): ?array
    {
        return $this->http->$method($this->getUrl('countries', $id), $params)->json();
    }
}
