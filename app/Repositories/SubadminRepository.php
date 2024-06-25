<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\SubadminInterface;
use App\Models\Admin;

use Illuminate\Support\Facades\Hash;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubadminRepository implements SubadminInterface
{
    use UploadAble;

    public function listAll()
    {
        return Admin::all();
    }

    public function listExpAdmin()
    {
        $data = array();
        DB::enableQueryLog();
        if(Auth::user()->id == 1){
            /* If super admin or partner one not showing himself */
            $data = Admin::where('id', '!=', Auth::user()->id)->get();
        }else{
            // die('Hi');
            /* If partner two not showing super admin creator and himself  */
            $data = Admin::whereNotIn('id', [1,Auth::user()->id])->get();
            // dd(DB::getQueryLog($data));
        }
        
        
        return $data;
        // return Admin::where('type', '!=', 1)->get();
    }




    public function listById($id)
    {
        return Admin::where('id',$id)->get();
    }





    public function create(array $data)
    {

        try {
            $collectedData = collect($data);
            $newEntry = new Admin;

            $newEntry->name = $collectedData['name'];
            $newEntry->email = $collectedData['email'];
            $newEntry->type = $collectedData['type'];
            $newEntry->status = 1;
            $newEntry->password = Hash::make($collectedData['password']);



            // slug generate


            // main image handling
            // $upload_path = "uploads/Admin/";
            // $image = $collectedData['image'];
            // $imageName = time() . "." . $image->getClientOriginalName();
            // $image->move($upload_path, $imageName);
            // $uploadedImage = $imageName;
            // $newEntry->image = $upload_path . $uploadedImage;
            $newEntry->save();



            DB::commit();
            return $newEntry;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    public function update($id, array $newDetails)
    {
        // dd($id);


        try {

            $updatedEntry = Admin::findOrFail($id);
            // dd($updatedEntry);
            $collectedData = collect($newDetails);


            $updatedEntry->name = $collectedData['name'];
            $updatedEntry->email = $collectedData['email'];
            // $updatedEntry->type = $collectedData['type'];
            // $updatedEntry->password = Hash::make($collectedData['password']);
            $updatedEntry->save();



            DB::commit();
            return $updatedEntry;
        } catch (\Throwable $th) {
        //    dd($th);
            throw $th;
            DB::rollback();
        }
    }

    public function toggle($id)
    {
        $updatedEntry = Admin::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }


    public function delete($id)
    {
        Admin::destroy($id);
    }


}
