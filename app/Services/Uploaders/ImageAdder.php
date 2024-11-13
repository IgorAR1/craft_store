<?php

namespace App\Services\Uploaders;

use App\Contracts\HasImage;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageAdder
{
    private UploadedFile $uploadedFile;
    private HasImage $model;
    private string $pathToFile;
    private string $fileName;
    private string $fileType;
    private string $fileHashName;

    public function setUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;
        $this->fileName = $uploadedFile->getClientOriginalName();
        $this->fileType = $uploadedFile->getClientMimeType();
        $this->fileHashName = $uploadedFile->hashName();

        return $this;
    }

    public function setUploadPath(string $uploadPath): self
    {
        $this->pathToFile = $uploadPath;

        return $this;
    }
    public function setModel(HasImage $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function createImage(): File
    {
        $file = new File();

        $file->storage_type = 'public';

        $file->file_name = $this->fileName;
        $file->file_type = $this->fileType;
        $file->file_path = $this->pathToFile .'/'.$this->fileHashName;

        $file->save();

        return $file;
    }

    public function addImage(File $file): void
    {
        $this->model->image()->save($file);
    }

    public function addImageToDisk(): bool
    {
        return Storage::disk('public')->putFile($this->pathToFile, $this->uploadedFile);
    }

    private function determineLink(File $file): string
    {
        return request()->path().$file->id.'/'.'file';
    }

}
