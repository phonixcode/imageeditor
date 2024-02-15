<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClipDropService;
use Illuminate\Support\Facades\Validator;

class ImageEditorController extends Controller
{
    protected $clipDropService;

    public function __construct(ClipDropService $clipDropService)
    {
        $this->clipDropService = $clipDropService;
    }

    public function cleanupImageView()
    {
        return view('page.cleanup');
    }

    public function cleanupImage(Request $request)
    {
        try {
            $originalImageDimensions = getimagesize($request->file('image')->getPathname());

            // Get the dimensions of the original image
           $validator = Validator::make($request->all(), [
                'image'     => 'required|file|mimes:jpeg,png|max:30720|dimensions:max_width=5000,max_height=5000|max:16000000', // Max 30 MB, 16 megapixels
                'mask'      => [
                    'required',
                    'file',
                    'mimes:png',
                    'max:30720',
                    function ($attribute, $value, $fail) use ($originalImageDimensions) {
                        $maskDimensions = getimagesize($value);

                        if ($originalImageDimensions[0] !== $maskDimensions[0] || $originalImageDimensions[1] !== $maskDimensions[1]) {
                            $fail("The dimensions of the mask must match the dimensions of the original image.");
                        }
                    }
                ],
                'edit_task' => 'required|in:cleanup',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Process the image cleanup request
            return $this->processImageRequest($request, 'cleanup');

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

     public function removeBackgroundView()
     {
        return view('page.remove-bkg');
     }

    public function removeBackground(Request $request)
    {
        try {
            // Validate the request parameters for removeBackground
           $request->validate([
                'image'         => 'required|file|mimes:png,jpg,jpeg,webp|max:30720|dimensions:max_width=5000,max_height=5000|max:25000000', // Max 30 MB, 25 megapixels
                'edit_task'     => 'required|in:remove_background',
            ]);

            // Process the background removal request
            return $this->processImageRequest($request, 'remove_background');

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function processImageRequest(Request $request, $editTask)
    {
        try {
            // Upload the image to a temporary location
            $imageUrl = $request->file('image')->store('uploads', 'public');

            // Perform the specified image editing task
            if ($editTask === 'cleanup') {
                $maskUrl = $request->file('mask')->store('uploads', 'public');
                $editedImage = $this->clipDropService->cleanupImage($imageUrl, $maskUrl);
            } else {
                $editedImage = $this->clipDropService->removeBackground($imageUrl);
            }

            // Return the edited image URL or data to the frontend
            return response()->json(['editedImage' => $editedImage], 200);

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
