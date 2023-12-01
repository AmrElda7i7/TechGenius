<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:create_user')->only(['create','store']) ;
        $this->middleware('permission:update_user')->only(['edit','update']) ;
        $this->middleware('permission:delete_user')->only(['destroy']) ;
        $this->middleware('permission:show_users')->only(['index' , 'show']) ;
        $this->middleware('permission:generate_temp_link')->only(['show_temp_link' , 'generate_temp_link']) ;
        
    }
    public function index()
    {
        $users = User::where('id' , '!=' , auth()->id())->get();
        return view('admin.users.users', compact('users'));
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $roles = Role::all();
            $user= User::findOrFail($id) ;
            return view('admin.users.edit', compact('roles', 'user'));
        } catch (\Exception $e) {
            return \generalException('users.index');
        } catch (ModelNotFoundException $e) {
            abort(404);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::FindOrFail($id);
            $user->update($request->only(['name','email','password']));
            $user->assignRole($request->role);
            return redirect()->route('users.index')
                ->with('success', 'User has been updated successfully');
        } catch (\Exception $e) {
            return \generalException('users.index');
        } catch (ModelNotFoundException $e) {
            abort(404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', 'user has been deleted successfully');
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            return \generalException('users.index');
        }
    }
    public function generate_temp_link()
    {
        $roles = Role::all();
        return view('admin.users.temp_link' ,get_defined_vars());
    }
    public function show_temp_link(Request $request)
    {
        $this->validate($request, [
            'hours' => 'required|numeric',
        ]);
        $tempUrl= URL::temporarySignedRoute(
            'temp_register', now()->addHours($request->hours),['role'=>$request->role]
        );
        return $tempUrl ;
        
    }
}