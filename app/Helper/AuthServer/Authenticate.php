<?php

namespace App\Helper\AuthServer;

class Authenticate extends AuthServerGateway
{
    public function apply(string $method, array $params = [], int $id = null): array
    {
        return $this->http->$method($this->getUrl('admin-login', $id), $params)->json();
    }
}
