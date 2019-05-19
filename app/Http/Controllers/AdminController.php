<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Http\Classes\Groups;

class AdminController extends Controller
{
    //
    public function __invoke(){
    	$admin = Admin::all();
        $group = Groups::where('name', '!=', 'Super Admin')->get()->toArray();
         return view('back/admins',  compact('admin','group'));
    }
    public function permits(){
    	return view('back/permitsAdmin');
    }

    public function register(){
        $group = Groups::where('name', '!=', 'Super Admin')->get()->toArray();
        return view('back/form/admin', compact('group'));
    }
     public function group(){
        $admin = Admin::where('is_admin', '!=', 2)->get();
        $group = Groups::where('name', '!=', 'Super Admin')->get()->toArray();
        return view('back/groupAdmin', compact('admin', 'group'));
    }

    public function addGroup(Request $request){
        if (!Groups::where('name', $request->group)->exists()) {
            $group = new Groups();
            $group->name = $request->group;
            $group->save();
            return back()->with('txt', 'grupo creado con exito');
        }else{
            return back()->with('error', 'el grupo ya existe');
        }
    }

    public function deleteGroup($id){
        $group = Groups::find($id);
        $group->delete();
        return back();
    }

    public function configurationGroup($id){
        $group = Groups::find($id);
        return view('back/configGroup', compact('group'));
    }

    public function formAdmin(Request $request){
    	if (strlen($request->pass) >= 6) {
    		if (!Admin::where('email', $request->email)->exists()) {
	    		$admin = new Admin();
	    		$admin->firstname = $request->firstname;
	    		$admin->lastname = $request->lastname;
	    		$admin->email = $request->email;
	    		$admin->password = bcrypt($request->pass);
	    		$admin->is_admin =  0;
                if (isset($request->group) && $request->group != 0) {
                    $admin->group_id = $request->group;
                }else{
                    $admin->group_id = 0;
                }
	    		$admin->save();
	    		return back()->with('txt', 'Successfully registered administrator!');
	    	}else{
	    		return back()->with('error', 'The mail is already in use!'); 
	    	}
    	}else{
    		return back()->with('error', 'The password must be greater than or equal to 6 characters!');  
    	}
    	
    }

    public function changeState(Request $request){
    	//dd($request->id);
    	if (Admin::where('id', $request->id)->exists()) {
    		$admin = Admin::find($request->id);
    		if ($admin->is_admin === 1) {
    			$admin->is_admin = 0;
    		}else if ($admin->is_admin === 0) {
    			$admin->is_admin = 1;
    		}
    		$admin->save();
    		return back();
    	}
    }

    public function deleteAdmin(Request $request){
    	//dd($request->id);
    	if (Admin::where('id', $request->id)->exists()) {
			$admin = Admin::find($request->id);
			$admin->delete();
    		return back();
    	}

    }
}
