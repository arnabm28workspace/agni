<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\AdminService;
use Illuminate\Support\Facades\Session;

class ProfileController extends BaseController
{
    protected $adminService;

    /**
     * ProfileController constructor
     */
    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth:web');
        $this->adminService = $adminService;
    }
    public function dashboard()
    {
		//$profile = $this->adminService->fetchProfile(Auth::user()->id);
        $this->setPageTitle('Dashboard', 'Manage Dashboard');
        return view('admin.dashboard.index');
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		// $profile = $this->adminService->fetchProfile(Auth::user()->id);
        $profile = User::find(Auth::user()->id);
        $this->setPageTitle('Profile', 'Manage Profile');
        return view('admin.profile.index', compact('profile'));
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:200",

        ]);
        $updateRequest = $request->all();
        $id = Auth::user()->id;

        // $this->adminService->updateProfile($updateRequest, $id);
        User::where('id',$id)->update(['name'=>$request->name]);
        // return $this->responseRedirectBack('admin.admin.profile','Profile updated successfully.', 'success',false, false);
        Session::flash('message', 'Profile updated successfully.'); 
        return redirect()->route('admin.admin.profile');
        
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request) {
        $request->validate([
            "current_password" => "required|string|min:6|",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required|string|min:6",
        ]);
        $id = Auth::user()->id;

        if(Hash::check($request->current_password, Auth::user()->password)){
            // echo Auth::user()->password; die;
            User::where('id',$id)->update(['password' => Hash::make($request->password)]);
            // return $this->responseRedirectBack('admin.admin.profile','Password changed successfully.', 'success',false, false);
            Session::flash('message', 'Password changed successfully.'); 
            return redirect()->route('admin.admin.profile');
        } else {
            return redirect()->back()->withErrors(['current_password'=> "Current password is wrong"])->withInput();
        }
        

        // $info = $this->adminService->changePassword($request, $id);

        // if ($info['type'] == 'error') {
        //     return $this->responseRedirectBack($info['message'], $info['type'], true, true, '#password');
        // } else {
        //     return $this->responseRedirectBack('Password updated successfully.', 'success');
        // }
    }
}
