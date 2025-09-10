<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $tenant = Tenant::where('email', $data['email'])->first();

        if(!$tenant || !Hash::check($data['password'], $tenant->password)){
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse([
            'tenant' => $tenant,
        ]);
    }

    public function register(Request $request){
        $data = $request->validate([
            'email' => 'required|string|email',
            'name' => 'required|string',
            'password' => 'required|string',
            'plan' => 'required|string',
        ]);

        $tenant = Tenant::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'plan' => $data['plan'],
            'active' => true,
            'api_secret' => Str::random(32),
            'api_key' => Str::random(64),
        ]);

        return $this->successResponse([
            'tenant' => $tenant,
        ]);
    }
}
