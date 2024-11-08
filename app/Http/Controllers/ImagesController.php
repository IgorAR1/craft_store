<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Files;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function store(ImageUploadRequest $request)
    {
        $data = $request->validated();

        $image = new Files();

        dd(Storage::get('local'));
    }
}
