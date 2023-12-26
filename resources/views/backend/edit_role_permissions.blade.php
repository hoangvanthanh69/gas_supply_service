@extends('layouts.admin_gas')
@section('sidebar-active-list-permissions', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">   
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-phan-quyen')}}">Danh sách phân quyền /</a>
                <a class="text-decoration-none color-name-admin-add" href="">Gán quyền cho quản trị viên</a>
                </span>
            </div>
            
            <div class="add-staff-form">
                <div class="search-infor-amdin-form-staff mt-3">
                  <a class="add-product" href="{{route('add-permissions')}}">Thêm quyền</a>
                </div>
                @if (session('success'))
                    <div class="change-password-customer-home d-flex">
                    <i class="far fa-check-circle icon-check-success"></i>
                    {{ session('success') }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="success-customer-home-notification d-flex">
                    <i class="fas fa-ban icon-check-cancel"></i>
                    {{ session('message') }}
                    </div>
                @endif
                <div class="add-staff-heading-div">
                    <span>Cập nhật quyền cho nhân viên</span>
                </div>
                <form enctype="multipart/form-data" method="post" action="{{ route('update-role-permissions', $role_permissions->id) }}">
                    @csrf
                    <div class="edit-role-pemission">
                        <div class="text-center">
                            <label class="fs-5 me-2" for="">Cập nhật thiết lập quyền:</label>
                            <span name="id_admin" class="color-name-admin-add fw-bolder fs-5">{{ $admin_name }}</span>
                        </div>
                        <div class="">
                            <div class="ms-3 me-3">
                                @foreach ($permissionsByRightsGroup as $rightsGroupName => $permissions)
                                    <div class="border-buttom-permission">
                                        <label class="right-group-name">{{ $rightsGroupName }}</label>
                                        <div class="row ms-3 me-3">
                                            @foreach($permissions as $permission)
                                                <div class="col-4">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->permission_id }}" data-group="{{$rightsGroupName}}" @if(in_array($permission->permission_id, $selectedPermissions)) checked @endif>
                                                    {{ $permission->permission_name }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="check-rights-group-name color-logo-gas">
                                            <input type="checkbox" class="check-group" data-group="{{ $rightsGroupName}}">
                                            <span>Check tất cả trong nhóm</span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="name-add-product-all mt-3">
                                    <span>Check tất cả</span>
                                    <input type="checkbox" class="check-all">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a class="back-product" href="{{ route('quan-ly-phan-quyen') }}">Trở lại</a>
                        <button class="add-product button-add-product-save" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="checkbox"].check-group').change(function() {
            const group = $(this).data('group');
            const checkboxesInGroup = $(`input[type="checkbox"][data-group="${group}"]`);
            checkboxesInGroup.prop('checked', $(this).prop('checked'));
        });

        $('input[type="checkbox"].check-all').change(function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });

        $('input[type="checkbox"]').not('.check-group, .check-all').change(function() {
            const group = $(this).data('group');
            const allCheckboxesInGroup = $(`input[type="checkbox"][data-group="${group}"]`);
            const checkedCheckboxesInGroup = $(`input[type="checkbox"][data-group="${group}"]:checked`);
            if (allCheckboxesInGroup.length === checkedCheckboxesInGroup.length) {
                $(`input[type="checkbox"].check-group[data-group="${group}"]`).prop('checked', true);
            } else {
                $(`input[type="checkbox"].check-group[data-group="${group}"]`).prop('checked', false);
            }
        });
    });
</script>