<?php

namespace Brid\Cache;

use Brid\Core\Foundation\Providers\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{

  public function boot()
  {
    $this->container->set('cache', new Redis());
  }

}