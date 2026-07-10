<?php

namespace App\Services;

use Illuminate\Http\Request;

class FileUploadService
{
    /**
     * Handle file upload from request.
     *
     * @param Request $request
     * @param string $fileInputName
     * @param string $disk
     * @return array|null Returns array with 'type', 'file_url', 'file_name' or null if no file.
     */
    public function handleMessageFile(Request $request, string $fileInputName = 'file', string $disk = 'public'): ?array
    {
        if (!$request->hasFile($fileInputName)) {
            return null;
        }

        $file = $request->file($fileInputName);
        $mimeType = $file->getMimeType();

        if (str_starts_with($mimeType, 'image/')) {
            $type = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $type = 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            $type = 'audio';
        } else {
            $type = 'document';
        }

        $fileName = $file->getClientOriginalName();
        $path = $file->store('uploads', $disk);
        $fileUrl = url('storage/'.$path);

        return [
            'type' => $type,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
        ];
    }
}
