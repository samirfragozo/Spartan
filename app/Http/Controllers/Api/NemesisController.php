<?php

namespace App\Http\Controllers\Api;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NemesisController extends Controller
{
    public function saveFingerprint(Request $request)
    {
        if($request->has('uploadedFile')){

            if(!Storage::exists('public/fingerprints')) Storage::makeDirectory('public/fingerprints');

            $id = $request->input('id');
            $file = $request->file('uploadedFile');
            $extension = $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('fingerprints', $file, "$id.$extension");

            Client::find($id)->notifyUpdate();
        }
    }
}
