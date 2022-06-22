<?php

namespace App\Helper\AuthServer;

class User extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): ?array
    {
        return $this->http->$method($this->getUrl('users', $id), $params)->json();
    }
}
