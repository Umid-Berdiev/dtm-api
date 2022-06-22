<?php

namespace App\Helper\AuthServer;

class Me extends AuthServerGateway
{
    public function apply(string $method = 'get', array $params = [], int $id = null): array
    {
        return $this->http->$method($this->getUrl('me', $id), $params)->json();
    }
}
