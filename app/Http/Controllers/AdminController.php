<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Http\Classes\Groups;
use App\Http\Classes\PermitGroups;
use App\Http\Classes\Permit;
use Route;
use Auth;

class AdminController extends Controller
{
    //
    public function __invoke(){
    	$admin = Admin::all();
        $group = Groups::where('name', '!=', 'Super Admin')->get()->toArray();
        $access = PermitGroups::where(['permit_id' => 1, 'groups_id' => Auth::guard('admins')->user()->group_id])->exists();
         return view('back/admins',  compact('admin','group', 'access'));
    }
    public function permits(){
         
        $group = Groups::where('name', '!=', 'Super Admin')->get();
        $permits = Permit::all();
        $permitGroup = PermitGroups::all();
    	return view('back/permitsAdmin', compact('group','permits','permitGroup'));
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

    /*public function configurationGroup($id){
        $group = Groups::find($id);
        $admins = Admin::where('group_id', $group->id)->orWhere('group_id', null)->get();
        $permits = Permit::all();
        $permitGroup = PermitGroups::where('groups_id',$group->id)->get();
        return view('back/configGroup', compact('group','admins','permits','permitGroup'));
    }*/

    public function loadGroup(Request $request){
        $group = Groups::find($request->group);
        $permitGroup = PermitGroups::where('groups_id',$group->id)->get();
        $permits = Permit::all();
        $data = [];
        foreach ($permits as $per) {
            if($permitGroup->contains('permit_id', $per->id)){
                $per->type = 0; 
                $data[] = $per;
            }else{
                $per->type = 1; 
                $data[] = $per;
            }
            /*foreach ($permitGroup as $value) {
                 
                if($value->permit_id != $per->id  ){
                    $data[] =  $per;
                     
                }
            }*/
        }
        $url =  url('/admin/dashboard/group/options');
        return response()->json(['group' => $data, 'url' => $url]);
    }

    public function options(Request $request){
         $permit = Permit::find($request->permit);
         $group = Groups::find($request->group);
        
        //return response()->json(['txt' => $permit->id, 'group' => $group->id]);
        if ($request->btn === "permit") {
            $permitGroup = new PermitGroups();
            if ($request->type === "insert") {
                if (!PermitGroups::where(['permit_id' => $permit->id, 'groups_id' => $group->id])->exists()) {
                    $permitGroup->permit_id = $permit->id;
                    $permitGroup->groups_id = $group->id;
                    if ($permitGroup->save()) {
                        return response()->json(['txt' => 'Permiso asigando con exito']);
                    }else{
                        return response()->json(['txt' => 'Permiso no asigando con exito']);

                    }
                }else{
                        return response()->json(['txt' => 'Permiso ya asigando anteriormente']);

                }
                
                 
            }
            if ($request->type === "delete") {
                $permitsGroup = PermitGroups::where('groups_id', $group->id)->get();
                //return response()->json(['txt' => $permitsGroup]);
                
                    if ( PermitGroups::where(['permit_id' => $permit->id, 'groups_id' => $group->id])->delete()) {
                        return response()->json(['txt' => 'Permiso eliminado con exito']);
                    }else{
                        return response()->json(['txt' => 'Permiso no eliminado con exito']);
                    }
            
                    
                // return response()->json(['txt' => 'delete']);
            }
        }
        if ($request->btn === "group") {
            $admin = Admin::find($request->admin);
            if ($request->type === "insert") {
                

                if ($admin->group_id == null) {
                    $admin->group_id = $group->id;
                    if ($admin->save()) {
                        return response()->json(['txt' => 'Grupo asignado con exito']);
                    }else{
                        return response()->json(['txt' => 'Grupo no asignado con exito']);

                    }
                }

                

                
                 
            }
            if ($request->type === "delete") {
                if ($admin->group_id != null) {
                    $admin->group_id = null;
                    if ($admin->save()) {
                        return response()->json(['txt' => 'Grupo quitado con exito']);
                    }else{
                        return response()->json(['txt' => 'Grupo no quitado con exito']);

                    }
                }
            
                    
                // return response()->json(['txt' => 'delete']);
            }
        }
       
        /*$msg = "This is a simple message.";
      return response()->json(array('msg'=> $msg), 200);*/
    }

    public function formAdmin(Request $request){
    	if (strlen($request->pass) >= 6) {
    		if (!Admin::where('email', $request->email)->exists()) {
                //dd($request);
	    		$admin = new Admin();
	    		$admin->firstname = $request->firstname;
	    		$admin->lastname = $request->lastname;
	    		$admin->email = $request->email;
	    		$admin->password = bcrypt($request->pass);
	    		$admin->is_admin =  0;
                if (isset($request->group) && $request->group != 0) {
                    $admin->group_id = $request->group;
                }else{
                    $admin->group_id = null;
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
