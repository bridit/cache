<?php

namespace Brid\Cache;

use Predis\Client;
use Predis\ClientInterface;

class Redis
{

  protected ClientInterface $client;

  public function __construct()
  {
    $this->store();
  }

  public function store(string $name = null)
  {
    $cacheConfig = config('cache');

    $name ??= $cacheConfig['default'];
    $connection = $cacheConfig['stores'][$name]['connection'] ?? null;

    if ($connection === null) {
      return;
    }

    $settings = $cacheConfig['redis'][$connection] ?? [];
    $options = $cacheConfig['redis']['options'] ?? [];

    $this->client = new Client($settings, $options);

    return $this;
  }

  public function __call(string $name , array $arguments): mixed
  {
    return $this->client->{$name}(...$arguments);
  }

}