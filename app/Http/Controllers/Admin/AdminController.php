<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class AdminController extends Controller
{
    public function index()
    {
        return view('page.setting');
    }

    public function updateApiKey(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'key' => 'required|string',
        ]);

        // Update the .env file
        $envFilePath = base_path('.env');
        $key = strtoupper('CLIPDROP_API_KEY');
        $value = $request->key;

        // Write the new value to the .env file
        if (File::put($envFilePath, str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents($envFilePath)
        ))) {
            // Return success message
            return redirect()->back()->with('success', 'CLIPDROP_API_KEY has been updated successfully.');
        }

        // Return error message if unable to update .env file
        return redirect()->back()->with('error', 'Failed to update CLIPDROP_API_KEY.');
    }
}
