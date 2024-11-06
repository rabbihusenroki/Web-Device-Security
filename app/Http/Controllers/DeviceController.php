<?php

namespace App\Http\Controllers;
use App\Models\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function register(Request $request)
{
    $request->validate(['name' => 'required|string']);
    $deviceToken = bin2hex(random_bytes(16));

    $device = Device::create([
        'name' => $request->name,
        'device_token' => $deviceToken,
    ]);

    return response()->json([
        'message' => 'Device registered successfully',
        'device_token' => $device->device_token,
    ]);
}

}
