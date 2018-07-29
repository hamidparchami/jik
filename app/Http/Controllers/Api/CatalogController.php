<?php

namespace App\Http\Controllers\Api;

use App\Catalog;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function getCatalogList(Request $request)
    {
        $last_login_date = '2018-05-01';

        return Catalog::where('is_active', 1)
            ->with(['category' => function ($query) use($last_login_date) {
                $query->withCount([
                    'contents' => function ($query) use($last_login_date) {
                        $query->whereDate('updated_at', '>', $last_login_date);
                    }
                ]);
            }
            ])
            ->get();
    }
}
