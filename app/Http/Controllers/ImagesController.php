<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\File;
use App\Models\Product;
use App\Services\Uploaders\ImageAdder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function __construct(private ImageAdder $imageAdder)
    {
    }

    public function store(ImageUploadRequest $request,Product $product)
    {
        $this->imageAdder->setModel($product)->createImage();
    }

    public function upload(Request $request,Product $product,File $image)
    {
        $this->imageAdder->setModel($product)->setUploadedFile($request->file('file'))->addImage($image);
    }
}
