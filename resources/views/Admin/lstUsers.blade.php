@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Users</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Users</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
    </section>
    @if(Session::get('err'))
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
      <script>
          var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      Toast.fire({
            icon: 'success',
            title: '{{ Session::get('err') }}',
            background: '#20c997',
          })
      </script>
        @endif
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body filterable">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tfoot style="display: table-header-group">
                    <tr class="filters">
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Full Name"></th>
                      <th><input type="text" class="form-control" placeholder="User Name"></th>
                      <th><input type="text" class="form-control" placeholder="Email"></th>
                      <th><input type="text" class="form-control" placeholder="Phone"></th>
                      <th><input type="text" class="form-control" placeholder="Number"></th>
                      <th></th>
                      <th></th>
                    </tr>
                    </tfoot>
                  <tbody>
                    <?php $i = 0 ?>
                    @foreach ($us as $key=>$task)
                    <?php $i++ ?>
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $task->getUser->fullname }}</td>
                      <td>{{ $task->getUser->username }}</td>
                      <td>{{ $task->getUser->email }}</td>
                      <td>{{ $task->getUser->phone }}</td>
                      <td>{{ $task->getUser->number }}</td>
                      <td><input type="checkbox" @if ($task->getUser->active==1) @checked(true)@endif onclick="return false;"></td>
                      <td>
                        <button title="Edit" type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#edt{{ $task->id }}"><i class="far fa-edit"></i></button>
                    </td>


                    {{-- edit --}}
                    <div class="modal fade" id="edt{{ $task->getUser->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('edituser') }}" method="POST">
                              {{ csrf_field() }}
                            <label>Name</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->getUser->fullname}}"  name="edtUname" class="form-control mr-1">
                                </div>
                            <label>Email</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->getUser->email}}"  name="edtUemail" class="form-control mr-1">
                                </div>
                            <label>Phone</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->getUser->phone}}"  name="edtUphone" class="form-control mr-1">
                                </div>
                            <label>Role</label>
                                <div class="input-group mb-1">
                                    <select name="edtUrole" class="form-control">
                                      <option @if($task->role=="Admin") style="background-color: #E0E0E0;" selected @endif value="Admin">Admin</option>
                                      <option @if($task->role=="Doctor") style="background-color: #E0E0E0;" selected @endif value="Doctor">Doctor</option>
                                      <option @if($task->role=="Secretary") style="background-color: #E0E0E0;" selected @endif value="Secretary">Secretary</option>
                                    </select>
                                </div>
                            <label>Reset Password </label>
                                <div class="form-group">
                                    <input type="text"  class="form-control" name="password" placeholder="Enter new password">
                                </div>

                            <div class="form-check">
                               &nbsp;<input class="form-check-input" type="checkbox" value="{{$task->getUser->active}}"
                                @if ($task->getUser->active==1) @checked(true)@endif name="edtUactive" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">Active</label>
                            </div>


                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" value="{{ $task->getUser->id }}" name="id" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                        </div>
                        </div>
                    </div>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
