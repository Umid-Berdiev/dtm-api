<?php

namespace App\Helper\AuthServer;

class Logout extends AuthServerGateway
{
    public function apply(string $method = 'post', array $params = [], int $id = null): array
    {
        return $this->http->$method($this->getUrl('logout', $id), $params)->json();
    }
}
