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

    public function getCheckForUpdates(Request $request)
    {
        if (!empty($request->currentVersion) && !empty($request->platform)) {
            $variableForForceUpdateCurrentVersion = 'forceUpdate' . $request->currentVersion . 'For' . $request->platform;
            $latestVersion = VariableValue::where('variable', 'latestVersionFor'.$request->platform)->where('is_active', 1)->get(['value'])->first();
            $latestVersionUpdateUrl = VariableValue::where('variable', 'latestVersionUpdateUrlFor'.$request->platform)->where('is_active', 1)->get(['value'])->first();
            $forceUpdateCurrentVersion = VariableValue::where('variable', $variableForForceUpdateCurrentVersion)->where('is_active', 1)->get(['value'])->first();

            $data['latestVersion']  = $latestVersion->value;
            $data['forceUpdate']    = ($forceUpdateCurrentVersion == 'true') ? true : false;
            $data['updateUrl']      = $latestVersionUpdateUrl->value;

            return $data;
        } else {
            return response([
                'success' => false,
                'code' => 404,
                'message' => 'Resource not found.'
            ]);
        }
    }
}
