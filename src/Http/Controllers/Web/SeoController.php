<?php

namespace Module\Seo\Http\Controllers\Web;

use Illuminate\Routing\Controller;

abstract class SeoController extends Controller
{
    abstract function detail($id);
}
