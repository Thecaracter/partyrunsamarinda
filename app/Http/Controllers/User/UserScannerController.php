<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserScannerController extends Controller
{
    public function index()
    {
        return view('user.scan');
    }

    public function getBibCard($number)
    {
        try {
            // Format the BIB number to match your file naming (e.g., 20001.jpg)
            $formattedNumber = $number;
            if (!str_starts_with($number, '2')) {
                $formattedNumber = '2' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }

            $path = public_path("qr-code/{$formattedNumber}.jpg");

            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'BIB card not found'
                ], 404);
            }

            return response()->file($path);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving BIB card'
            ], 500);
        }
    }
}