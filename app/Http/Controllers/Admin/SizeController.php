<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SizeController extends Controller
{
    public function index()
    {
        try {
            $sizes = Size::latest()->get();
            return view('admin.size', compact('sizes'));
        } catch (\Exception $e) {
            Log::error('Error fetching sizes: ' . $e->getMessage());
            return back()->with('error', 'Failed to load sizes. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:sizes',
                'stock' => 'required|integer|min:0'
            ]);

            Size::create($validated);

            return redirect()->route('admin.sizes.index')
                ->with('success', 'Size created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating size: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create size. Please try again.');
        }
    }

    public function update(Request $request, Size $size)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
                'stock' => 'required|integer|min:0'
            ]);

            $size->update($validated);

            return redirect()->route('admin.sizes.index')
                ->with('success', 'Size updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating size: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update size. Please try again.');
        }
    }

    public function destroy(Size $size)
    {
        try {
            if ($size->peserta()->exists()) {
                return back()->with('error', 'Cannot delete size that is being used by participants');
            }

            $size->delete();
            return redirect()->route('admin.sizes.index')
                ->with('success', 'Size deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting size: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete size. Please try again.');
        }
    }
}