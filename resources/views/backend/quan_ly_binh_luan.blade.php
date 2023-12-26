@extends('layouts.admin_gas')
@section('sidebar-active-comment', 'active' )
@section('content')
<div class="col-10 nav-row-10 ">
    <div class="card mb-3 product-list element_column" data-item="staff">
        <div class="card-header">
          <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-binh-luan')}}">Quản lý bình luận</a></span>
        </div>
        <div class="search-option-infor-amdin mt-3 me-1">
            <div id="notify_comment"></div>
            <div class="search-infor-amdin-form">
              <form action="{{route('search-comment')}}" method="GET" class="header-with-search-form">
                @csrf
                <i class="search-icon-discount fas fa-search"></i>
                <input type="text" autocapitalize="off" class="header-with-search-input-discount" placeholder="Tìm kiếm" name="search">
                <span class="header_search button" onclick="startRecognition()">
                  <i class="fas fa-microphone" id="microphone-icon"></i> 
                </span>
              </form>
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
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-list-product">
              <table class="table table-bordered" id="" width="100%" cellspacing="0">
                <thead>
                  <tr class="tr-name-table">
                    <th class="col-1">Duyệt</th>
                    <th class="col-2">Tên người gửi</th>
                    <th class="col-4">Nội dung bình luận</th>
                    <th class="col-2">Thời gian</th>
                    <th class="col-2">Nhân viên</th>
                    <th class="col-1">Chức năng</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @foreach($tbl_comment as $key => $val)
                    <tr class="hover-color">
                        <td class="product-order-quantity">
                          @if ($val -> status_comment == 1) 
                            <a href="{{route('unhide-comments', $val['id'])}}" data-comment_status="0" data-id="{{$val->id}}" id="{{$val->staff_id}}" class="button-hide-comment comment_duyet_btn">Đã duyệt</a>
                          @elseif ($val -> status_comment == 0) 
                            <a href="{{route('hide-comments', $val['id'])}}" data-comment_status="1" data-id="{{$val->id}}" id="{{$val->staff_id}}" class="button-unhide-comment comment_duyet_btn">Duyệt</a>
                          @endif
                        </td>
                        <td class="product-order-quantity">{{$val['comment_name']}}</td>
                        <td class="">
                          <div class="content-comment-customer">{{$val['comment']}}</div>
                          <br>
                          <ul class="list-rep-comment mb-2">
                            @foreach($comment_rep as $key => $comm_reply)
                              @if($comm_reply -> comment_parent_comment == $val->id)
                                <li>
                                  <div class="d-flex">
                                    <div>Trả lời: {{ $comm_reply->comment }}</div>
                                    <div class="next-delete-comment-reply">
                                      <span class="toggle-delete-comment-span">...</span>
                                    </div>

                                    <div class="delete-comment-reply-admin" style="display: none;">
                                      <form action="{{ route('delete_reply_comment', $comm_reply->id) }}">
                                        <button class="delete-comment-reply-admin-button">
                                          <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                                        </button>
                                      </form>
                                    </div>
                                  </div>
                                </li>
                              @endif
                            @endforeach
                          </ul>
                          @if($val -> status_comment == 1)
                            <textarea rows="2" class="form-control reply_comment_{{$val->id}} mb-1"></textarea>
                            <button class="btn-replaly-comment mb-1" data-id="{{$val->id}}" data-staff_id="{{$val->staff_id}}" data-user_id="{{$val->user_id}}">Trả lời</button>
                          @endif
                        </td>
                        <td class="product-order-quantity">{{$val['comment_date']}}</td>
                        <td class="product-order-quantity">{{$staffNames[$val['staff_id']]}}</td>
                        <td class="product-order-quantity">
                          <form action="{{route('delete_comment_admin', $val['id'])}}">
                            <button type="button" class="button-delete-order" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val['id']}}">
                              <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$val['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabel">Bạn có chắc muốn xóa bình luận này</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                                    <button class="summit-add-room-button btn btn-primary" type='submit'>Xóa</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $('.btn-replaly-comment').click(function(){
        var id = $(this).data('id');
        var comment = $('.reply_comment_'+id).val();
        var staff_id = $(this).data('staff_id');
        var user_id = $(this).data('user_id');
        // alert(comment);
        // alert(id);
        // alert(staff_id);
        // alert(user_id);
        $.ajax({
          url: "{{ route('reply-comment') }}",
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            comment:comment, id:id, staff_id:staff_id, user_id:user_id
          },
          success: function(data) {
            $('.reply_comment_'+id).val('');
            location.reload();
            $('#notify_comment').html('<span class="text text-alert ms-3">Trả lời bình luận thành công</span>');
          },
          error: function(xhr, status, error) {
          }
        });
      })

      setTimeout(function() {
        var alertElement = document.querySelector('.text-alert');
        if (alertElement) {
          alertElement.classList.add('hidden');
        }
      }, 8000);

      document.querySelectorAll('.toggle-delete-comment-span').forEach(function(span) {
        span.addEventListener('click', function() {
          var deleteCommentReply = this.parentElement.nextElementSibling;
          if (deleteCommentReply.style.display === 'none' || deleteCommentReply.style.display === '') {
            deleteCommentReply.style.display = 'block';
          } else {
            deleteCommentReply.style.display = 'none';
          }
        });
      });
    </script>
@endsection
