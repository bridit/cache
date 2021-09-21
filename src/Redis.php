<?php

namespace Brid\Cache;

use Predis\Client;
use Predis\ClientInterface;

class Redis
{

  protected ClientInterface $client;

  public function __construct()
  {
    $cacheConfig = config('cache');

    $settings = $cacheConfig['redis']['default'] ?? [];
    $options = $cacheConfig['redis']['options'] ?? [];

    $this->client = new Client($settings, $options);
  }

  public function __call(string $name , array $arguments): mixed
  {
    return $this->client->{$name}(...$arguments);
  }

}