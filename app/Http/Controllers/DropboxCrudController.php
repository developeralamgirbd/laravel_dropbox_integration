<?php

namespace App\Http\Controllers;

use App\Http\Requests\DropboxImageStoreRequest;
use App\Models\Dropbox;
use App\Models\DropboxCrud;
use App\Rules\ThrottleSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Kunnu\Dropbox\DropboxApp;
use function Symfony\Component\VarDumper\Dumper\esc;

class DropboxCrudController extends Controller
{
    public $isDisable = true;
    public $image;
    public function __constructor(){

    }

    public function index(){
        $trash = DropboxCrud::onlyTrashed()->count();
        $images = DropboxCrud::withoutTrashed()->paginate(4);
        $dropbox = Dropbox::first();
        $dropbox_app = new DropboxApp($dropbox->app_key, $dropbox->app_secret, $dropbox->access_token);
        $app = new \Kunnu\Dropbox\Dropbox($dropbox_app);
        $listFolderContents = $app->listFolder('/images', [
            "include_deleted" => true,
            "include_has_explicit_shared_members" => true,
            "include_media_info" => true,
            "include_mounted_folders" => true,
            "include_non_downloadable_files" => false,
            "path" => '/images',
            "recursive" => true
        ])->getData();
        $files  = $listFolderContents['entries'];
        $deletedImgFromDropbox = array_filter($files, function ($var) {
            return ($var['.tag'] == 'deleted');
        });
        $deleteImgFromDB = DropboxCrud::onlyTrashed()->select('img_url')->get()->toArray();
        $dropbox_deletedImg = array_column($deletedImgFromDropbox, 'name');
        $db_deletedImg = array_column($deleteImgFromDB, 'img_url');
        $deleted_images = array_intersect($dropbox_deletedImg, $db_deletedImg);
        $total_trash = count($deleted_images);
        return view('dropbox-crud', compact('images', 'trash', 'total_trash' ));
    }
//UW1KVmVYUk9XbVpVVW5ST2NtMW5RMjVHYWtwUVNGVkJSa1ZxWVdWa01YZEVUSEozUWtjeFVpNXFjR2RmTmpNd09ESTVNVFUxTVRFek1RPT0uanBnXzYzMDg1ODQ2NTNlYWE=.jpg
//
//UW1KVmVYUk9XbVpVVW5ST2NtMW5RMjVHYWtwUVNGVkJSa1ZxWVdWa01YZEVUSEozUWtjeFVpNXFjR2RmTmpNd09ESTVNVFUxTVRFek1RPT0uanBnXzYzMDg1ODQ2NTNlYWE=.jpg

//UW1KVmVYUk9XbVpVVW5ST2NtMW5RMjVHYWtwUVNGVkJSa1ZxWVdWa01YZEVUSEozUWtjeFVpNXFjR2RmTmpNd09ESTVNVFUxTVRFek1RPT0uanBnXzYzMDg1OGVlYThjMDQ=.jpg

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

    public function trash(){
        $dropbox = Dropbox::first();
        $dropbox_app = new DropboxApp($dropbox->app_key, $dropbox->app_secret, $dropbox->access_token);
        $app = new \Kunnu\Dropbox\Dropbox($dropbox_app);
        $listFolderContents = $app->listFolder('/images', [
            "include_deleted" => true,
            "include_has_explicit_shared_members" => true,
            "include_media_info" => true,
            "include_mounted_folders" => true,
            "include_non_downloadable_files" => false,
            "path" => '/images',
            "recursive" => true
        ])->getData();
        $files  = $listFolderContents['entries'];
        $deletedImgFromDropbox = array_filter($files, function ($var) {
            return ($var['.tag'] == 'deleted');
        });
        $deleteImgFromDB = DropboxCrud::onlyTrashed()->select('img_url')->get()->toArray();
        $dropbox_deletedImg = collect($deletedImgFromDropbox);
        $db_deletedImg = array_column($deleteImgFromDB, 'img_url');
        $deleted_images =  $dropbox_deletedImg->whereIn('name', $db_deletedImg)->all();
       $images = array_column($deleted_images, 'name');
        return view('trash', compact('images'));
    }

    public function restore($image){
        $dropbox = Dropbox::first();
        $dropbox_app = new DropboxApp($dropbox->app_key, $dropbox->app_secret, $dropbox->access_token);
        $app = new \Kunnu\Dropbox\Dropbox($dropbox_app);
        $revisions = $app->listRevisions('/images/'.$image,  ["limit" => 1]);
        $path = $revisions[0]->path_display;
        $rev = $revisions[0]->rev;
        $app->restore($path, $rev);
        $restore = DropboxCrud::withTrashed()->where('img_url', $image)->restore();
        return redirect()->route('dropbox.image.index');
    }

}
