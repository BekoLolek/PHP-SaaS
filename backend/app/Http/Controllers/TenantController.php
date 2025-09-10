<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    use ApiResponse;
    public function showTenantInfo(Request $request){
        $tenant = $request->attributes->get('tenant');
        $tenant = Tenant::findOrFail($tenant->id);
        return $this->successResponse(['tenant_info' => $tenant], 200);
    }

    public function generateNewApiForTenant(Request $request){
        $newApiKey = Str::random(32);
        $newApiSecret = Str::random(64);

        $tenant = $request->attributes->get('tenant');
        $tenant->api_key = $newApiKey;
        $tenant->api_secret = $newApiSecret;
        $tenant->save();

        return $this->successResponse(['api_key' => $newApiKey, 'api_secret' => $newApiSecret], 200);
    }
}
