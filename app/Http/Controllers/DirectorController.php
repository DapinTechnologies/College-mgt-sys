<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Models\Director;
 use Illuminate\Support\Facades\Storage;
class DirectorController extends Controller
{
    
    public function index()
    {
        $director = Director::first(); // Fetch only one director (not an array)
        return view('admin.director.index', compact('director'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Generate a unique filename
            $filename = time().'_'.$image->getClientOriginalName();
    
            // Store the image in the "public" disk under "uploads/director"
            $imagePath = $image->storeAs('uploads/director', $filename, 'public');
        }
    
        // Store the director details in the database
        Director::create([
            'name' => $request->name,
            'title' => $request->title,
            'message' => $request->message,
            'image' => $imagePath, // Save the image path
        ]);
    
        return redirect()->route('directors.index')->with('success', 'Director message added successfully.');

}

public function update(Request $request, $id)
{
    $director = Director::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($director->image) {
            Storage::disk('public')->delete($director->image);
        }

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('uploads/director', $filename, 'public');

        $director->image = $imagePath;
    }

    $director->update([
        'name' => $request->name,
        'title' => $request->title,
        'message' => $request->message,
        'image' => $director->image,
    ]);

    return redirect()->route('directors.index')->with('success', 'Director message updated successfully.');
}






}