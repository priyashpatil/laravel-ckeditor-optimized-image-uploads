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

        $defaultImage = Image::make($request->file('upload'));
        $imageWidth = $defaultImage->width();
        $imageSizes = [800, 1024, 1920];

        $filename = Str::ulid() . '.webp';
        $path = 'uploads/' . $filename;
        $defaultImage = $defaultImage->encode('webp', 80);
        Storage::disk('public')->put($path, (string)$defaultImage);
        $urls['default'] = Storage::disk('public')->url($path);

        foreach ($imageSizes as $size) {
            if ($imageWidth < $size) {
                break;
            }

            $image = Image::make($request->file('upload'))
                ->resize($size, null, fn($constraint) => $constraint->aspectRatio())
                ->encode('webp', 80);

            $path = 'uploads/' . Str::ulid() . "-$size.webp";
            Storage::disk('public')->put($path, (string)$image);
            $urls["$size"] = Storage::disk('public')->url($path);
        }

        $data = !empty($urls) ?
            ['urls' => $urls] :
            ['error' => ['message' => 'Upload failed!']];

        return response()->json($data);
    }
}
