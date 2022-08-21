<?php

namespace App\Http\Controllers;

use App\Http\Requests\DropboxImageStoreRequest;
use App\Models\DropboxCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\VarDumper\Dumper\esc;

class DropboxCrudController extends Controller
{
    public $isDisable = true;
    public function __constructor(){

    }

    public function index(){
        $trash = DropboxCrud::onlyTrashed()->get();
        $images = DropboxCrud::withoutTrashed()->paginate(4);
        return view('dropbox-crud', compact('images', 'trash'));
    }

    public function store(DropboxImageStoreRequest $input){
        $validated = $input->validated();
        if ($input->hasFile('image')){
            $file = $input->file('image');
            $fileName = base64_encode($file->getClientOriginalName().'_'.uniqid()).'.'.$file->getClientOriginalExtension();
            $file->storeAs('images/',$fileName, 'dropbox');
            DropboxCrud::create([
                'img_url'   => $fileName
            ]);
            return redirect()->route('dropbox.image.index')->with('success_msg', 'Image uploaded successfully');
        }

    }

    public function destroy($id){
       $id = Crypt::decrypt($id);
       $dropbox_crud = DropboxCrud::withoutTrashed()->where('id',$id)->first();
       Storage::disk('dropbox')->delete('images/'.$dropbox_crud->img_url);
       $dropbox_crud->delete();
       return redirect()->back()->with('success_msg', 'Image deleted successfully');
    }

}
