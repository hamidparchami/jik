<?php

namespace App\Http\Controllers\Api;

use App\Catalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function getCatalogList()
    {
        return Catalog::where('is_active', 1)->get();
    }
}
