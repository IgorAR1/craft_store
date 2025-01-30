<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\File;
use App\Models\Product;
use App\Services\Files\ImageAdder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageProductController extends Controller
{
    public function __construct(readonly ImageAdder $imageAdder)
    {
    }

    public function store(Product $product)
    {
        $this->imageAdder->setModel($product)->createImage();
    }

    public function upload(Request $request,Product $product,File $image)
    {
        $this->imageAdder->setModel($product)->setUploadedFile($request->file('file'))->addImage($image);
    }
}
