<?php

namespace App\Http\Controllers\Api;

use App\VariableValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VariableValueController extends Controller
{
    public function getView(Request $request)
    {
        $variableValue = VariableValue::where('variable', $request->variable)->where('is_active', 1)->get(['value'])->first();
        if (is_null($variableValue)) {
            return response([
                'success'   => false,
                'code'      => 404,
                'message'   => 'Resource not found.'
            ]);
        }

        return $variableValue;
    }
}
