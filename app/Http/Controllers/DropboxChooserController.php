<?php

namespace App\Http\Controllers;

use App\Http\Requests\DropboxChooserStoreRequest;
use App\Models\DropboxChooser;
use Illuminate\Http\Request;

class DropboxChooserController extends Controller
{
    public function dropboxChooser(){
        $chooser = DropboxChooser::all('img_url');
        return view('dropbox-chooser', compact('chooser'));
    }

    public function store(DropboxChooserStoreRequest $input){
        $validated = $input->validated();
        $chooser = DropboxChooser::create([
           'img_url' => $input['chooser_url']
        ]);

        return redirect()->back()->with('success_msg', 'Upload Successfully');
    }
}
