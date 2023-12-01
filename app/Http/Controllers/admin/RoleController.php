<?php
namespace App\Http\Controllers\Admin;

use App\Models\HashRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:update_role')->only(['update_role','edit_role']);
         $this->middleware('permission:delete_role')->only('destroy');
         $this->middleware('permission:create_role')->only(['create','store']);
         $this->middleware('permission:show_roles')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $my_role=auth()->user()->getRoleNames()->first();
        $roles = Role::where('name','!=',$my_role)->orderBy('id', 'DESC')->paginate(5);
        return view('admin.roles.roles', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('admin.roles.add', compact('permissions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        HashRole::create(
            [
                'role_id'=> $role->id,
                'hash'=> Hash::make($role->name),
                
            ]
        );
        foreach($request->permissions as $permission)
        {
            DB::table('role_has_permissions')->insert(
                [
                    'role_id'=> $role->id ,
                    'permission_id'=> $permission
                ]
                );
        }
       // for unknown reason this solution gives me an error 
        // $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('admin.roles.show', compact('role', 'permissions'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all()) ;
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        foreach($request->permissions as $permission)
        {
            DB::table('role_has_permissions')->where('permission_id' ,$permission)->delete() ;
            DB::table('role_has_permissions')->insert(
                [
                    'role_id'=> $role->id ,
                    'permission_id'=> $permission
                ]
                );
        }
       
       // for unknown reason this solution gives me an error 
        // $role->syncPermissions($request->permissions); 

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}