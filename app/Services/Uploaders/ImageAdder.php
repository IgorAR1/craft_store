<?php

namespace App\Services\Uploaders;

use App\Contracts\HasImage;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class ImageAdder
{
    private UploadedFile $uploadedFile;
    private HasImage $model;
    private string $pathToFile;
    private string $fileName;
    private string $fileType;

    public function setUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        $this->pathToFile = $uploadedFile->getPath().'/'.$uploadedFile->getFilename();
        $this->fileName = $uploadedFile->getClientOriginalName();
        $this->fileType = $uploadedFile->getClientMimeType();

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

        $this->model->image()->save($file);

        $file->file_path = $this->determinePath($file);

        return $file;
    }

    public function addImage(File $file): void
    {
        $file->file_name = $this->fileName;
        $file->file_type = $this->fileType;

        $file->save();

        $this->addImageToDisk();
    }

    public function addImageToDisk(): void
    {
        Storage::disk('public')->putFile($this->getStorageDirectory(), $this->uploadedFile);
    }

    private function getStorageDirectory(): string// полная шляпа но пока так
    {
        return "images/{$this->model->id}";
    }

    private function determinePath(File $file): string
    {
        return request()->path().$file->id.'/'.'file';
    }

}
