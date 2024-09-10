<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    public function upload($request, $fileKey = null)
    {
        try {
            $request->validate([
                $fileKey => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);

                // Define a unique file name
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Store the file in the 'uploads' directory (you can change this path)
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $res = [
                    'success' => true,
                    'file_path' => '/storage/' . $filePath,
                    'file_url' => Storage::url($filePath),
                    'message' => 'File uploaded successfully!',
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'No file was uploaded.',
                ];
            }
        } catch (\Exception $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
}
