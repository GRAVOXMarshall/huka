<?php

namespace App\Http\Controllers;

use Auth;
use Route;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Classes\Groups;
use App\Http\Classes\PermitGroups;
use App\Http\Classes\Permit;

class AdminController extends Controller
{
    //
    public function __invoke(){
    	
        $admins = DB::table('admins')
                ->join('groups', 'groups.id', '=', 'admins.group_id')
                ->select('admins.id', 'admins.group_id', 'admins.firstname' , 'admins.lastname', 'admins.email', 'groups.name')
                ->get();
        return view('back/content',  compact('admins'));
    }

    public function newAdmin(){
        $groups = Groups::where('name', '!=', 'Super Admin')->get();
        $admin = Admin::all();
        return view('back/newAdmin', compact('groups', 'admin'));
    }

    public function addGroup(Request $request){
        if (!Groups::where('name', $request->group)->exists()) {
            $group = new Groups();
            $group->name = $request->group;
            $group->save();
            return back()->with('txt', 'Group created successfully!');
        }else{
            return back()->with('error', 'The group already exists!');
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
                        return response()->json(['txt' => 'Successful permission!']);
                    }else{
                        return response()->json(['txt' => 'Permission not successful!']);

                    }
                }else{
                        return response()->json(['txt' => 'Permission already assigning previously!']);

                }
                
                 
            }
            if ($request->type === "delete") {
                $permitsGroup = PermitGroups::where('groups_id', $group->id)->get();
                //return response()->json(['txt' => $permitsGroup]);
                
                    if ( PermitGroups::where(['permit_id' => $permit->id, 'groups_id' => $group->id])->delete()) {
                        return response()->json(['txt' => 'Permission successfully removed!']);
                    }else{
                        return response()->json(['txt' => 'Permission not removed successfully!']);
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

    public function addAdmin(Request $request){
    	if (strlen($request->pass) >= 6) {
    		if (!Admin::where('email', $request->email)->exists()) {
                //dd($request);
	    		$admin = new Admin();
	    		$admin->firstname = $request->firstname;
	    		$admin->lastname = $request->lastname;
	    		$admin->email = $request->email;
	    		$admin->password = bcrypt($request->pass);
	    		$admin->is_admin =  1;
                if (isset($request->group) && $request->group != 0) {
                    $admin->group_id = $request->group;
                    $admin->save();
                    return back()->with('txt', 'Successfully registered administrator!');
                }else{
                    return back()->with('error', 'It is necessary to select a group!');
                }
	    	}else{
	    		return back()->with('error', 'The mail is already in use!'); 
	    	}
    	}else{
    		return back()->with('error', 'The password must be greater than or equal to 6 characters!');  
    	}
    	
    }

   /* public function changeState(Request $request){
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
    }*/

    public function deleteAdmin(Request $request){
    	//dd(decrypt($request->admin_id));
        $val = decrypt($request->admin_id);
    	if (Admin::where('id', $val)->exists()) {
			$admin = Admin::find($val);
			$admin->delete();
    		return back();
    	}

    }
}
