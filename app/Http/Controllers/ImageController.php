<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\AdditionalImage;

class ImageController extends Controller
{
    public function showForm()
    {
        return view('image.form');
    }

    public function create()
    {
        return view('image.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'caption.*' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_captions.*' => 'required',
            'additional_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store main images
        foreach ($request->caption as $key => $caption) {
            $imagePath = $request->file('images')[$key]->store('images', 'public');

            $image = Image::create([
                'caption' => $caption,
                'image_path' => $imagePath,
            ]);

            // Store additional images associated with the main image
            if ($request->has('additional_captions') && isset($request->additional_captions[$key])) {
                foreach ($request->additional_captions[$key] as $index => $additionalCaption) {
                    $additionalImagePath = $request->file('additional_images')[$key][$index]->store('additional_images', 'public');

                    AdditionalImage::create([
                        'image_id' => $image->id,
                        'additional_caption' => $additionalCaption,
                        'additional_image_path' => $additionalImagePath,
                    ]);
                }
            }
        }

        return redirect()->route('image.index')->with('success', 'Images uploaded successfully.');
    }

    public function index()
    {
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    // app/Http/Controllers/ImageController.php

    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('image.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_captions.*' => 'required',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = Image::findOrFail($id);

        $image->caption = $request->input('caption');

        if ($request->hasFile('image')) {
            // If a new image is uploaded, update the main image
            $imagePath = $request->file('image')->store('images', 'public');
            $image->image_path = $imagePath;
        }

        $image->save();

        // Update or add additional images
        if ($request->has('additional_captions')) {
            foreach ($request->additional_captions as $key => $additionalCaption) {
                if (isset($request->additional_images[$key]) && $request->hasFile('additional_images') && isset($request->additional_images[$key][$key])) {
                    // If a new additional image is uploaded, update or add it
                    $additionalImagePath = $request->file('additional_images')[$key][$key]->store('additional_images', 'public');

                    $additionalImage = AdditionalImage::updateOrCreate(
                        ['id' => $request->additional_image_ids[$key]],
                        [
                            'image_id' => $image->id,
                            'additional_caption' => $additionalCaption,
                            'additional_image_path' => $additionalImagePath,
                        ]
                    );
                }
            }
        }

        return redirect()->route('image.index')->with('success', 'Image updated successfully.');
    }
}
