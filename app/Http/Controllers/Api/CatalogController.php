<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function getCatalogList($account_id)
    {
        $default_last_visit_category_date = '2018-05-01';
        $customer = Customer::where('account_id', $account_id)->first();

        return DB::table('catalogs')
                    ->leftJoin('content_categories', 'catalogs.id', '=', 'content_categories.catalog_id')
                    ->select('catalogs.*')
                    ->select('content_categories.*')
                    ->selectRaw("(select count(*) from `contents` where `contents`.`category_id` = `content_categories`.`id` and date(`updated_at`) > IFNULL((select category_visit_logs.created_at from category_visit_logs where category_visit_logs.category_id=contents.category_id AND category_visit_logs.customer_id = ?), ?) and `contents`.`deleted_at` is null) as `contents_count`", [$customer->id, $default_last_visit_category_date])
                    ->where('catalogs.is_active', 1)
                    ->where('content_categories.is_active', 1)
                    ->whereNull('catalogs.deleted_at')
                    ->whereNull('content_categories.deleted_at')
                    ->get();
    }
}
