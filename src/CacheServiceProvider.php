<?php

namespace Brid\Cache;

use Brid\Core\Foundation\Providers\ServiceProvider;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\MemcachedConnector;
use Illuminate\Cache\RateLimiter;
use Illuminate\Redis\RedisManager;

class CacheServiceProvider extends ServiceProvider
{

  public function boot()
  {
    $this->container->set('redis', function ($app) {
      return new RedisManager($app, $app['config']['database.redis.client'], $app['config']['database.redis']);
    });

    $this->container->set('cache', function ($app) {
      return new CacheManager($app);
    });

    $this->container->set('cache.store', function ($app) {
      return $app['cache']->driver();
    });

    $this->container->set('cache.psr6', function ($app) {
      return new Psr16Adapter($app['cache.store']);
    });

    $this->container->set('memcached.connector', function () {
      return new MemcachedConnector;
    });

    $this->container->set(RateLimiter::class, function ($app) {
      return new RateLimiter($app->make('cache')->driver(
        $app['config']->get('cache.limiter')
      ));
    });
  }

}