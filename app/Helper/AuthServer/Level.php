<?php

namespace App\Helper\AuthServer;

class Level extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): ?array
    {
        return $this->http->$method($this->getUrl('levels', $id), $params)->json();
    }
}
