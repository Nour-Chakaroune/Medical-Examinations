@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h3> Update Account</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Edit</li>
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
    @if(Session::get('cannotdelete'))
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
          });
        Toast.fire({
              icon: 'error',
              title: '{{ Session::get('cannotdelete') }}',
              background: '#FF9494',
            })
        </script>
    @endif
        <script>
            $(document).ready(function(){
                $("#role").change(function(){
                   let stat=$.inArray('4',$("#role").val())>=0;
                        $("#SerialNumber").prop( "readonly", !stat );
                        if(stat == false)
                            $("#SerialNumber").val('');
                });
            });
            $( document ).ready(function() {
                let stat=$.inArray('4',$("#role").val())>=0;
                        $("#SerialNumber").prop( "readonly", !stat );
    });
        </script>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body filterable">
                <h2  style="color:#0096FF">Account</h2> <hr>

                            <form action="{{route('editusersave')}}" method="POST">
                              {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Full Name</label>
                                    <input type="text"  value="{{$u->fullname}}"  name="fullname" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('fullname')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>User Name</label>
                                    <input type="text"  value="{{$u->username}}"  name="username" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('username')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Email</label>
                                    <input type="text"  value="{{$u->email}}"  name="email" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>Phone</label>
                                    <input type="text"  value="{{$u->phone}}"  name="phone" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                                <?php
                                $x=0;
                                $x=App\Models\RoleUser::where('userId',$u->id)->where('roleId',4)->count()
                                ?>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Number</label>
                                    <input type="text"   value="{{$u->number}}"  name="number" class="form-control shadow-sm p-3 mb-1 mr-1 rounded"
                                            @if ($x == 0) ReadOnly @endif>
                                    @error('number')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>Reset Password</label>
                                    <input type="text"  class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="password" placeholder="Enter new password">
                                </div>
                            </div>

                            <br>
                                <div class="form-check">
                                   &nbsp;<input class="form-check-input" type="checkbox" value="active"
                                    @if ($u->active==1) @checked(true)@endif name="active" id="flexCheckDefault"/>
                                    <label class="form-check-label" for="flexCheckDefault">Active</label>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" value="{{ $u->id }}" name="id" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>



              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body filterable">
                <h2 style="color:#0096FF">Job Function</h2> <hr>
                        @php
                           $x = App\Models\Role::WhereNotIn('id', App\Models\RoleUser::select('roleId')->Where('userId',$u->id))->get();
                        @endphp
                        &nbsp;&nbsp;<label>Role</label>
                        @foreach ($ur as $key=>$ru )
                        <div class="form-group">
                            <div class="input-group col-6">
                                <input type="text"   value="{{$ru->getRole->role}}"  name="" class="form-control mr-1" ReadOnly >
                                <button title="Delete" type="button" class="btn btn-outline-danger"  data-toggle="modal" data-target="#dlt{{ $ru->id }}"><i class="far fa-trash-alt"></i></button>
                            </div>
                            {{-- Delete --}}
                            <div class="modal fade" id="dlt{{ $ru->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    Are you sure you want delete this Role?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    <a href="/user/role/delete/{{ $ru->id }}" class="btn btn-danger">Yes</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        &nbsp;&nbsp;<label>Add Role</label>
                        <form action="{{ route('addRole') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group col-6">
                            <select class="form-control select2 form " id="role" name="role[]" multiple data-placeholder="Select roles" style="width: 100%;">
                                @foreach ($x as $key=>$p )
                                    <option value="{{ $p->id }}" {{ (collect(old('role'))->contains($p->id)) ? 'selected':'' }} >{{ $p->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        &nbsp;&nbsp;<label>Serial Number</label>
                        <div class="form-group col-6">
                            <input type="text" placeholder="Serial number" id="SerialNumber" class="form-control" name="SerialNumber" readonly value="{{ old('SerialNumber') }}">
                            @error('SerialNumber')
                                <span class="text-danger" align="left">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                        <button type="submit" value="{{ $u->id }}" name="uid" class="btn btn-primary">Save changes</button>
                        </div>
                      </form>
                    </div>
                    </div>
                    </div>


        </div>
      </div>


      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body filterable">
                <h2 style="color:#0096FF">Permission</h2> <hr>
                @php
                    $p = App\Models\permission::WhereNotIn('id', App\Models\user_permission::select('permissionId')->Where('userId',$u->id))->orderBy('taskName', 'asc')->get();
                @endphp
                        &nbsp;<label>Given Permissions</label>
                        @foreach($up->chunk(3) as $chunk)
                            <div class="row">
                                @foreach($chunk as $key=>$pu)
                                    <div class="form-group input-group col-4">
                                        <input type="text"   value="{{$pu->getPermission->taskName}}"  name="" class="form-control mr-1" ReadOnly >
                                        <button title="Delete" type="button" class="btn btn-outline-danger"  data-toggle="modal" data-target="#dlt{{ $pu->id }}"><i class="far fa-trash-alt"></i></button>
                                    </div>

                        <div class="form-group">
                            {{-- Delete --}}
                            <div class="modal fade" id="dlt{{ $pu->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    Are you sure you want delete this Permission?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    <a href="/user/permission/delete/{{ $pu->id }}" class="btn btn-danger">Yes</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                                 @endforeach
                        </div>
                        @endforeach
                        <br>
                        <form action="{{route('addPermission')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            {{-- <div class="form-group col-6"> --}}
                            <div class="col-lg-6">
                            <label>Add Permission</label>
                            <select class="form-control select2 form " id="permission" name="permission[]" multiple data-placeholder="Select permissions" style="width: 100%;">
                                @foreach ($p as $key=>$addp )
                                    <option value="{{ $addp->id }}" {{ (collect(old('permission'))->contains($addp->id)) ? 'selected':'' }} >{{ $addp->taskName }}</option>
                                @endforeach
                            </select>
                            @error('permission')
                                <span class="text-danger" align="left">{{$message}}</span>
                            @enderror
                            </div>
                            {{-- </div> --}}
                            <div class="col-lg-6">
                                <label>Deadline in case the permission is temporary </label>
                                <div class="input-group date" id="deadlineDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input form" value="{{ old('date') }}" placeholder="Date" name="date" data-target="#deadlineDate"/>
                                    <div class="input-group-append" data-target="#deadlineDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                        <button type="submit" value="{{ $u->id }}" name="uid" class="btn btn-primary">Save changes</button>
                        </div>
                      </form>
                    </div>
                    </div>
                    </div>


        </div>
      </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
