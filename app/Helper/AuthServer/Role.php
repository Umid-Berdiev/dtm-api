<?php

namespace App\Helper\AuthServer;

class Role extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): ?array
    {
        return $this->http->$method($this->getUrl('roles', $id), $params)->json();
    }
}
