<?php

namespace App\Http\Controllers;

class DownloadFilesController extends Controller
{
    public function __invoke(string $file)
    {
        $filePath = public_path('downloads/'.$file.'.xlsx');

        if (!file_exists($filePath)) {
            return null;
        }

        return response()->download($filePath);
    }
}
