<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\tbl_role_permissions;
use Illuminate\Support\Facades\Auth;
use Session;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $permissionId
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permissionId){
        if (Session::get('admin') != null) {
            $user = Session::get('admin');
            $userIdAdmin = $user['admin_id'];
            $rolePermission = tbl_role_permissions::where('id_admin', $userIdAdmin)->first();
            if ($rolePermission) {
                $adminPermissions = json_decode($rolePermission->id_permissions, true);

                if (in_array($permissionId, $adminPermissions)) {
                    return $next($request);
                }
            }
            return redirect()->back()->with('message', 'Bạn không có quyền truy cập');
        } else {
            return redirect()->route('login');
        }
    }

}    
