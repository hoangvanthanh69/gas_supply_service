<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\tbl_permissions;
use App\Models\tbl_role_permissions;
use App\Models\tbl_rights_group;
use App\Models\tbl_admin;
class PermissionsController extends Controller
{
    // quản lý phân quyền
    function quan_ly_phan_quyen() {
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        $tbl_role_permissions = tbl_role_permissions::get();
        $admin_Names = [];
        $permissionsNames = [];
        foreach ($tbl_role_permissions as $name) {
            $admin_id = $name->id_admin;
            $tbl_admin = tbl_admin::find($admin_id);
            if ($tbl_admin) {
                $admin_name = $tbl_admin;
                if (!isset($admin_Names[$admin_id])) {
                    $admin_Names[$admin_id] = $admin_name;
                    $permissionsNames[$admin_id] = [];
                }
                $infor_permission = json_decode($name->id_permissions, true);
                if (is_array($infor_permission)) {
                    foreach ($infor_permission as $infor) {
                        $permission = tbl_permissions::find($infor);
                        if ($permission) {
                            $rightsGroup = tbl_rights_group::find($permission->id_rights_group);
                            if ($rightsGroup) {
                                $rightsGroupName = $rightsGroup->name_rights_group;
                                if (!in_array($rightsGroupName, $permissionsNames[$admin_id])) {
                                    $permissionsNames[$admin_id][] = $rightsGroupName;
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('backend.quan_ly_phan_quyen', ['admin_Names' => $admin_Names, 'permissionsNames' => $permissionsNames]);
    }
    
    // giao diện thêm quyền
    function add_permissions(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_rights_group = tbl_rights_group::get();
        return view('backend.add_permissions', ['tbl_rights_group' => $tbl_rights_group]);
    }

    // thêm quyền
    function add_permission(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $data = $request -> all();
        $add_permission = new tbl_permissions();
        $add_permission -> permission_name = $data['permission_name'];
        $add_permission -> id_rights_group = $data['id_rights_group'];
        $add_permission -> save();
        return redirect()->route('add-role-permission')->with('success', 'Thêm quyền thành công');
    }

    // giao diện gán quyền cho admin
    function add_role_permission() {
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        $adminsWithPermissions = tbl_role_permissions::distinct('id_admin')->pluck('id_admin')->toArray();
        $tbl_admin = tbl_admin::whereNotIn('id', $adminsWithPermissions)->get();
        $tbl_permissions = tbl_permissions::get();
        $permissionsByRightsGroup = [];
        foreach ($tbl_permissions as $permission) {
            $rightsGroupName = tbl_rights_group::find($permission->id_rights_group)->name_rights_group;
            if (!isset($permissionsByRightsGroup[$rightsGroupName])) {
                $permissionsByRightsGroup[$rightsGroupName] = [];
            }
            $permissionsByRightsGroup[$rightsGroupName][] = $permission;
        }
        return view('backend.add_role_permission', ['tbl_admin' => $tbl_admin, 'permissionsByRightsGroup' => $permissionsByRightsGroup]);
    }
    

    // thêm gán quyền cho admin
    function role_permissions(Request $request){
        $data = $request->all();
        $admin_id = $data['admin_id'];
        $selectedPermissions = $data['permissions'];
        $permissionsJSON = json_encode($selectedPermissions);
        $role_permissions = new tbl_role_permissions();
        $role_permissions->id_admin = $admin_id;
        $role_permissions->id_permissions = $permissionsJSON;
        $role_permissions->save();
        return redirect()->route('quan-ly-phan-quyen')->with('success', 'Cập nhật gán quyền thành công');
    }

    // cập nhật lại gán quyền cho admin
    function updateRolePermissions(Request $request, $id) {
        $role_permissions = tbl_role_permissions::find($id);
        $role_permissions->id_permissions = $request->input('permissions', []);
        $role_permissions ->save();
        return redirect()->route('quan-ly-phan-quyen')->with('success', 'gán quyền thành công');
    }

    // giao diện edit gán quyền cho quản trị viên
    function edit_role_permissions($id_admin){
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        $role_permissions = tbl_role_permissions::where('id_admin', $id_admin)->first();
        $admin = tbl_admin::find($id_admin);
        $admin_name = $admin->admin_name;
        $tbl_permissions = tbl_permissions::get();
        $permissionsByRightsGroup = [];
        foreach ($tbl_permissions as $permission) {
            $rightsGroupName = tbl_rights_group::find($permission->id_rights_group)->name_rights_group;
            if (!isset($permissionsByRightsGroup[$rightsGroupName])) {
                $permissionsByRightsGroup[$rightsGroupName] = [];
            }
            $permissionsByRightsGroup[$rightsGroupName][] = $permission;
        }
        $selectedPermissions = json_decode($role_permissions->id_permissions, true);
        return view('backend.edit_role_permissions', ['role_permissions' => $role_permissions, 'admin_name' => $admin_name, 
        'tbl_permissions' => $tbl_permissions, 'selectedPermissions' => $selectedPermissions, 'permissionsByRightsGroup' => $permissionsByRightsGroup]);
    }

    // hiển thị thêm nhóm quyền
    function add_rights_group(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        return view('backend.add_rights_group');
    }

    // xử lý thêm nhóm quyền
    function add_rights_groups(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $data = $request->all();
        $add_rights_groups = new tbl_rights_group();
        $add_rights_groups -> name_rights_group = $data['name_rights_group'];
        $add_rights_groups ->save();
        return redirect()->route('add-permissions')->with('success', 'Thêm nhóm quyền thành công');
    }

    // dánh sách quyền
    function danh_sach_quyen(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_permissions = tbl_permissions::get();
        $rights_group = [];
        foreach ($tbl_permissions as $name_group) {
            $rights_group[$name_group->	id_rights_group] = tbl_rights_group::find($name_group->id_rights_group)->name_rights_group;
        }
        return view('backend.danh_sach_quyen', ['tbl_permissions' => $tbl_permissions, 'rights_group' => $rights_group]);
    }

    // chỉnh sửa quyền
    function edit_permissions($permission_id){
        $tbl_permissions = tbl_permissions::find($permission_id);
        $tbl_rights_group = tbl_rights_group::get();
        return view('backend.edit_permissions', ['tbl_permissions' => $tbl_permissions, 'tbl_rights_group' => $tbl_rights_group]);
    }

    // cập nhật quyền
    function update_permissions(Request $request, $id){
        $tbl_permissions = tbl_permissions::find($id);
        $tbl_permissions->id_rights_group = $request->id_rights_group;
        $tbl_permissions->permission_name = $request->permission_name;
        // dd($tbl_permissions);die;
        $tbl_permissions ->save();
        return redirect()->route('danh-sach-quyen')->with('success', 'Cập nhật quyền thành công');
    }

    // xóa quyền
    function delete_permissions($id){
        $tbl_permissions = tbl_permissions::find($id);
        $tbl_permissions -> delete();
        return redirect()->route('danh-sach-quyen')->with('success', 'Xóa quyền thành công');
    }
    
    // xóa gán quyền
    function delete_role_permissions($id_admin){
        $role_permissions = tbl_role_permissions::where('id_admin', $id_admin)->first();
        $role_permissions -> delete();
        return redirect()->route('quan-ly-phan-quyen')->with('success', 'Xóa gán quyền thành công');
    }

    // danh sách nhóm quyền
    function danh_sach_nhom_quyen(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_rights_group = tbl_rights_group::get();
        return view('backend.danh_sach_nhom_quyen', ['tbl_rights_group' => $tbl_rights_group]);
    }

    // giao diện chỉnh sửa nhóm quyền
    function edit_tbl_rights_group($id){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_rights_group = tbl_rights_group::find($id);
        return view('backend.edit_tbl_rights_group', ['tbl_rights_group' => $tbl_rights_group]);
    }

    // xử lý chỉnh sửa nhóm quyền
    function update_tbl_rights_group(Request $request, $id){
        $tbl_rights_group = tbl_rights_group::find($id);
        $tbl_rights_group -> name_rights_group = $request->name_rights_group;
        $tbl_rights_group -> save();
        return redirect()->route('danh-sach-nhom-quyen')->with('success', 'Cập nhật nhóm quyền thành công');
    }

    // tìm kiếm quyền
    function search_permissions(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $tbl_permissions = tbl_permissions::where(function($query) use ($search) {
                $query->where('permission_id', 'LIKE', "%$search%")
                      ->orWhere('permission_name', 'LIKE', "%$search%");
            })->get();
            $rights_group = [];
            foreach ($tbl_permissions as $name_group) {
                $rights_group[$name_group->	id_rights_group] = tbl_rights_group::find($name_group->id_rights_group)->name_rights_group;
            }
            if($tbl_permissions->isEmpty()){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.danh_sach_quyen', ['tbl_permissions' => $tbl_permissions, 'search' => $search, 'rights_group'=>$rights_group]);
            }
        } else {
            return redirect()->back();
        }
    }

    // tìm kiếm gán quyền
    function search_role_permissions(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $tbl_role_permissions = tbl_role_permissions::where(function($query) use ($search) {
                $query->where('id_admin', 'LIKE', "%$search%");
            })->get();
            $admin_Names = [];
            $permissionsNames = [];
            foreach ($tbl_role_permissions as $name) {
                $admin_id = $name->id_admin;
                $tbl_admin = tbl_admin::find($admin_id);
                if ($tbl_admin) {
                    $admin_name = $tbl_admin;
                    if (!isset($admin_Names[$admin_id])) {
                        $admin_Names[$admin_id] = $admin_name;
                        $permissionsNames[$admin_id] = [];
                    }
                    $infor_permission = json_decode($name->id_permissions, true);
                    if (is_array($infor_permission)) {
                        foreach ($infor_permission as $infor) {
                            $permission = tbl_permissions::find($infor);
                            if ($permission) {
                                $rightsGroup = tbl_rights_group::find($permission->id_rights_group);
                                if ($rightsGroup) {
                                    $rightsGroupName = $rightsGroup->name_rights_group;
                                    if (!in_array($rightsGroupName, $permissionsNames[$admin_id])) {
                                        $permissionsNames[$admin_id][] = $rightsGroupName;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($tbl_role_permissions->isEmpty()){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.quan_ly_phan_quyen', ['tbl_role_permissions' => $tbl_role_permissions, 'search' => $search, 'admin_Names' => $admin_Names, 'permissionsNames' => $permissionsNames]);
            }
        } else {
            return redirect()->back();
        }
    }
    
}