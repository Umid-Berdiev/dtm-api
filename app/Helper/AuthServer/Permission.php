<?php

namespace App\Helper\AuthServer;

class Permission extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): ?array
    {
        return $this->http->$method($this->getUrl('permissions', $id), $params)->json();
    }
}
