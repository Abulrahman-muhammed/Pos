<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
class UploadimageService
{
    public function uploadImage($image, $folder , $usage)
    {
        $newImageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs($folder, $newImageName, 'public');
        return[
            'path' => $path,
            'usage' => $usage,
            'ext'=> $image->getClientOriginalExtension()
        ];
    }

    public function delete($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}