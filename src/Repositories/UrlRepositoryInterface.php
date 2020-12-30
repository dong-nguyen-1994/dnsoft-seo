<?php

namespace Module\Seo\Repositories;

use Dnsoft\Core\Repositories\BaseRepositoryInterface;

interface UrlRepositoryInterface extends BaseRepositoryInterface
{
    public function findByRequestPath($path, $columns = ['*']);

    public function whereMathRequestPath($path, $columns = ['*']);
}
