<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\File;
use App\Models\Product;
use App\Services\Uploaders\ImageAdder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UploadImageController extends Controller
{
    public function __construct(readonly ImageAdder $imageAdder)
    {}

    public function store(Request $request): Response
    {
        $file = $this->imageAdder
            ->setUploadedFile($request->file('image'))
            ->setUploadPath('tmp/images')
            ->createImage();

        $ids = $file->getKey();

        $success = $this->imageAdder->addImageToDisk();

        if ($success){
            return response()->json(['image_id' => $ids],status: 201);
        }

        return response(status: 400);
    }
}
