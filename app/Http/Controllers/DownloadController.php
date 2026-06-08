<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        // Link download dari GitHub
        $downloadLink = 'https://github.com/ipzoone/apk-storage/releases/latest/download/dvpets.apk';
        
        return view('download', compact('downloadLink'));
    }
}
