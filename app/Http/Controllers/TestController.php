<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostalCode;
use App\Models\Province;

class TestController extends Controller
{
    public function index()
    {
        return view('test.test');
    }

    /**
     * Search postal codes via AJAX
     */
    public function searchPostalCode(Request $request)
    {
        $query = $request->input('q');

        if (empty($query) || strlen($query) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal 3 digit kode pos'
            ]);
        }

        $results = PostalCode::where('postal_code', 'LIKE', $query . '%')
            ->with('province')
            ->limit(15)
            ->get()
            ->map(function ($item) {
                return [
                    'postal_code' => $item->postal_code,
                    'urban' => $item->urban,
                    'sub_district' => $item->sub_district,
                    'city' => $item->city,
                    'province_code' => $item->province_code,
                    'province_name' => $item->province->province_name ?? 'N/A',
                    'display' => $item->postal_code . ' - ' . $item->urban . ', ' . $item->sub_district . ', ' . $item->city
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}
