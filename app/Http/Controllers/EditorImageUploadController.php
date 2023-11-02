<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EditorImageUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), ['upload' => 'required|file|image|max:5000']);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'message' => $validator->errors()->first('upload')
                ]
            ], 400);
        }

        $filename = Str::ulid() . '.webp';
        $path = 'uploads/' . $filename;
        $defaultImage = Image::make($request->file('upload'))->encode('webp', 80);
        Storage::disk('public')->put($path, (string)$defaultImage);
        $imageURL = Storage::disk('public')->url($path);

        return response()->json(['url' => $imageURL]);
    }
}
