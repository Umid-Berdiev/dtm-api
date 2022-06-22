<?php

namespace App\Helper\AuthServer;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class AuthServerGateway
{
  public PendingRequest $http;

  public function __construct()
  {
    $headers = [
      'key' => config('services.keys.oauth'),
      'module' => config('services.module.prefix'),
      'Authorization' => 'Bearer ' . request()?->bearerToken(),
    ];

    $this->http = Http::acceptJson()->withHeaders($headers);
  }

  protected function getUrl(string $url, int $id = null): string
  {
    return config('services.urls.oauth') . '/' . $url . (($id) ? '/' . $id : '');
  }
}
