<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContentBlock;
use Illuminate\Support\Facades\Storage;

class ContentBlockController extends Controller
{
    // Method to fetch the hero section
    public function getHeroSection()
    {
        $content = ContentBlock::where('section', 'hero')->first();
        return response()->json($content);
    }

    // Method to fetch the consultation content
    public function getConsultation()
    {
        $content = ContentBlock::where('section', 'consultation')->first();
        return response()->json($content);
    }

    // Method to fetch the about content
    public function getAbout()
    {
        $content = ContentBlock::where('section', 'about')->first();
        return response()->json($content);
    }

    // Method to fetch the logo content (new)
    public function getLogo()
    {
        $content = ContentBlock::where('section', 'logo')->first();
        return response()->json($content);
    }

    // Method to update the hero section
    public function updateHeroSection(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'button_text' => 'nullable|string|max:255',
        ]);

        $content = ContentBlock::where('section', 'hero')->first();

        $content->title = $request->title;
        $content->text = $request->text;
        $content->button_text = $request->button_text;

        // Handle image upload for hero section
        if ($request->hasFile('image_path')) {
            if ($content->image_path) {
                Storage::disk('public')->delete($content->image_path);
            }
            $content->image_path = $request->file('image_path')->store('images', 'public');
        }

        $content->save();
        return response()->json(['success' => 'Hero section updated successfully.']);
    }

    // Method to update the consultation section
    public function updateConsultation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $content = ContentBlock::where('section', 'consultation')->first();

        // Handle image upload for consultation section
        if ($request->hasFile('image_path') && $content->consultation_image_path) {
            Storage::disk('public')->delete($content->consultation_image_path);
        }

        $content->title = $request->title;
        $content->text = $request->text;

        if ($request->hasFile('image_path')) {
            $content->image_path = $request->file('image_path')->store('images', 'public');
        }

        $content->phone_number = $request->phone_number;
        $content->save();

        return response()->json(['success' => 'Consultation section updated successfully.']);
    }

    // Method to update the about section
    public function updateAbout(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        $content = ContentBlock::where('section', 'about')->first();

        // Handle image upload for about section
        if ($request->hasFile('image_path')) {
            $request->validate(['image_path' => 'image|max:2048']);
            if ($content->image_path) {
                Storage::disk('public')->delete($content->image_path);
            }
            $content->image_path = $request->file('image_path')->store('images', 'public');
        }

        $content->title = $request->title;
        $content->text = $request->text;
        $content->save();

        return response()->json(['success' => 'About section updated successfully.']);
    }

    // Method to update the logo section (new)
    public function updateLogo(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|max:2048', // Validate logo image
        ]);

        $content = ContentBlock::where('section', 'logo')->first();

        // If there's an existing logo, delete it
        if ($content->image_path) {
            Storage::disk('public')->delete($content->image_path);
        }

        // Store the new logo and update the path
        $content->image_path = $request->file('image_path')->store('logos', 'public');
        $content->save();

        return response()->json(['success' => 'Logo updated successfully.']);
    }
}
