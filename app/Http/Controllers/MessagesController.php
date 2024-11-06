<?php

namespace App\Http\Controllers;
use App\Models\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function sendMessage(Request $request)
{
    $request->validate([
        'device_token' => 'required|string|exists:devices,device_token',
        'message' => 'required|string',
    ]);

    $device = Device::where('device_token', $request->device_token)->first();
    $encryptedMessage = \App\Helpers\EncryptionHelper::encrypt($request->message, $device->device_token);

    return response()->json([
        'encrypted_message' => $encryptedMessage
    ]);
}

public function receiveMessage(Request $request)
{
    $request->validate([
        'device_token' => 'required|string|exists:devices,device_token',
        'encrypted_message' => 'required|string',
    ]);

    $device = Device::where('device_token', $request->device_token)->first();
    $decryptedMessage = \App\Helpers\EncryptionHelper::decrypt($request->encrypted_message, $device->device_token);

    return response()->json([
        'decrypted_message' => $decryptedMessage
    ]);
}

}
