<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempRegister extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(404);
        }
        $role= $request->input("role");
        $signature= $request->input("signature");
        return view('admin.users.register',get_defined_vars());
    }
}
