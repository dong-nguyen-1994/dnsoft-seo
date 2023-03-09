<?php

namespace Module\Seo\Repositories\Eloquent;

use Module\Seo\Repositories\UrlRepositoryInterface;
use DnSoft\Core\Repositories\BaseRepository;

class UrlRepository extends BaseRepository implements UrlRepositoryInterface
{
    public function findByRequestPath($path, $columns = ['*'])
    {
        return $this->model->where('request_path', $path)->firstOrFail($columns);
    }

    public function whereMathRequestPath($path, $columns = ['*'])
    {
        return $this->model
            ->where('request_path', $path)
            ->get($columns);
    }
}
