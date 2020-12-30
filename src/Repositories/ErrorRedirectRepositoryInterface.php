<?php

namespace Module\Seo\Repositories;

use Dnsoft\Core\Repositories\BaseRepositoryInterface;

interface ErrorRedirectRepositoryInterface extends BaseRepositoryInterface
{
    public function findBy($key, $value, $columns = ['*']);
}
