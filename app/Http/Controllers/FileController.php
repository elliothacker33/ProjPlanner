<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\isNull;

class FileController extends Controller
{   static $diskName = 'proj_planner_files';
    public static function getDefaultName(String $type): string{
        $filename = null;
        switch ($type) {
            case "user": 
                $filename = "default-profile-photo.jpg";
                break;
            default: 
                $filename = "";
                break;
        }
        return $filename;
    }
    private static function defaultAsset(String $type,String $diskRoot) {
        return asset('/'. $diskRoot .'/' . $type . '/'. self::getDefaultName($type)); 
    }

    private static function getFileName (String $type, int $id) {
        $fileName = null;
        $model = null;
        switch($type) {
            case 'user':
                $model = User::find($id);
                $fileName = $model->file;
                break;
            }
    
        return $fileName;
    }
    public static function get(String $type, int $id) {
        $diskRoot = config("filesystems.disks." . self::$diskName . ".root");
        $fileName = self::getFileName($type, $id);
        return asset( '/'.$diskRoot.'/' . $type . '/'.$fileName); 
    }
    private static function validRequest(Request $request):bool{
        // Maybe change Validator.
        if($request->hasFile("file") && $request->file("file")->isValid()){ 
            return true;
        }
        return false;
    }

    private static function getModel(String $type,int $id): Model{
        $model = null;
        switch($type){
            case "user": 
                $model = User::find($id);
                break;
            /*
            case "task":
                $model = Task::find($request->id);
                break;
            */
        }
        return $model;
    }
    private static function changeModel(Request $request, Model $model):Model{
        $type = $request->type;
        $diskRoot = config("filesystems.disks." . self::$diskName . ".root");
        switch($type){
            case "user":
                if($model->file != self::getDefaultName($type))
                    self::deleteFile($request,$model->file);
                $model->file = $request->file('file')->hashName();
                break;
            /*case 'task':
                */
        }
        return $model;
    }
    private static function saveModel(Request $request,Model $model):void{
        $model->save();
        Storage::putFileAs($request->type, new File($request->file('file')),$model->file);
    }
    
    private static function getMessageSuccess(string $type){
        $message = null;
        switch($type){
            case 'user':
                $message ='Your profile image was updated with success';
                break;
            default:
                $message = 'Success';
                break;
        }
        return $message;
    }
    private static function getMessageError(string $type){
        $message = null;
        switch($type){
            case 'user':
                $message ='Error updating your profile image';
                break;
            default:
                $message = 'Error';
                break;
        }
        return $message;
    }
    public static function upload(Request $request) {
        if(self::validRequest($request)){
            $model = self::getModel($request->type, $request->id);
            $model = self::changeModel($request,$model);
            self::saveModel($request,$model);
            $message = self::getMessageSuccess($request->type);
            return redirect()->back()->with('success',$message);
        }
        $message = self::getMessageError($request->type);
        return redirect()->back()->with('error',$message);
    }

    // Delete not tested yet.
    private static function deleteFile(Request $request,String $file) {
        $diskRoot = config("filesystems.disks." . self::$diskName . ".root");
        Storage::disk(self::$diskName)->delete('/'.$request->type.'/'.$file);
    }
    public static function delete(Request $request) {
        $diskRoot = config("filesystems.disks." . self::$diskName . ".root");
        $model = self::getModel($request->type,$request->id);
        if ($model->file == self::defaultAsset($request->type,$diskRoot)){
            return redirect()->intended(route('home', ['usrId' => $request->id]))->with('error', 'Can\'t delete default profile image');
        }
        if ($model && !empty($model->file) ) {
            self::deleteFile($request, $model->file);
        }
        $model->file = self::defaultAsset($request->type,$diskRoot);
        $model->save();
        return redirect()->intended(route('home', ['usrId' => $request->id]));
    }
    

}
