<?php

namespace TypiCMS\Modules\Partners\Repositories;

use TypiCMS\Modules\Core\Custom\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Custom\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PartnerInterface
{
    public function __construct(PartnerInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
