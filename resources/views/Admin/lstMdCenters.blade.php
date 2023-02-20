@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h3>
            <a href="" class="nav-link" id="addmedd" data-toggle="modal" data-target="#addmed">
                <i class="fas fa-plus-circle"></i> New Medical Center </a>
            </h3>
          </div>
          <div class="col-sm-9">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Medical Centers</li>
            </ol>
          </div>
        </div>
      </div>
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
            timer: 3000
          });
        Toast.fire({
              icon: 'error',
              title: '{{ Session::get('cannotdelete') }}',
              background: '#FF9494',
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
                    <th>Name</th>
                    <th>Address</th>
                    <th>Full Address</th>
                    <th>Phone</th>
                    <th>Fax</th>
                    <th width="10%">Action</th>
                  </tr>
                  </thead>
                  <tfoot style="display: table-header-group">
                    <tr class="filters">
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Name"></th>
                      <th><input type="text" class="form-control" placeholder="Address"></th>
                      <th><input type="text" class="form-control" placeholder="Full Address"></th>
                      <th><input type="text" class="form-control" placeholder="Phone"></th>
                      <th><input type="text" class="form-control" placeholder="Fax"></th>
                      <th></th>
                    </tr>
                    </tfoot>
                  <tbody>
                    <?php $i = 0 ?>
                    @foreach ($Mds as $key=>$task)
                    <?php $i++ ?>
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $task->namee }}</td>
                      <td>{{ $task->addr }}</td>
                      <td>{{ $task->fulladd }}</td>
                      <td>{{ $task->phone }}</td>
                      <td>{{ $task->fax }}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button title="Edit" type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#edt{{ $task->id }}"><i class="far fa-edit"></i></button>
                            <button title="Delete" type="button" class="btn btn-outline-danger"  data-toggle="modal" data-target="#dlt{{ $task->id }}"><i class="far fa-trash-alt"></i></button>
                        </div>
                        </td>

                    {{-- edit --}}
                    <div class="modal fade" id="edt{{ $task->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Medical Center</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('editmdcenter') }}" method="POST">
                              {{ csrf_field() }}
                            <label>Name</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->namee}}"  name="edtname" class="form-control mr-1" id="testname">
                                    {{-- @error('edtname')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror --}}
                                </div>

                            <label>Address</label>
                                <div class="input-group mb-1">
                                    <select name="edtaddr" value="" id="" class="form-control">
                                        <option @if($task->addr == "محافظة بيروت") style="background-color: #E0E0E0;" selected @endif >محافظة بيروت</option>
                                        <option @if($task->addr == "محافظة جبل لبنان") style="background-color: #E0E0E0;" selected @endif >محافظة جبل لبنان</option>
                                        <option @if($task->addr == "محافظة الشمال") style="background-color: #E0E0E0;" selected @endif >محافظة الشمال</option>
                                        <option @if($task->addr == "محافظة البقاع") style="background-color: #E0E0E0;" selected @endif >محافظة البقاع</option>
                                        <option @if($task->addr == "محافظة الجنوب") style="background-color: #E0E0E0;" selected @endif >محافظة الجنوب</option>
                                      </select>
                                </div>
                            <label>Full Address</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->fulladd}}"  name="edtfulladdr" class="form-control mr-1" id="fulladdr">
                                </div>
                            <label>Phone</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->phone}}"  name="edtphone" class="form-control mr-1" id="phone">
                                </div>
                            <label>Fax</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->fax}}"  name="edtfax" class="form-control mr-1" id="fax">
                                </div>

                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" value="{{ $task->id }}" name="id" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                        </div>
                    </div>
                    {{-- delete --}}
                    <div class="modal fade" id="dlt{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            Are you sure you want delete this medical center?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <a href="/medicalcenter/delete/{{ $task->id }}" class="btn btn-danger">Yes</a>
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

{{-- add --}}
<div class="modal fade" id="addmed" tabindex="-1" role="dialog" aria-labelledby="addmed" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add medical center</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('addMedicalCenter') }}" method="POST" autocomplete="off">
          @csrf
          <div class="form-group">
          <div class="input-group mb-1">
            <input type="text" placeholder="Enter medical center name" value="{{old('name')}}"  name="name" class="form-control mr-1">
          </div>
            @error('name')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
            <div class="input-group mb-1">
              <select name="addr" value="" id="" class="form-control select2 form" data-placeholder="Select address" style="width: 100%;">
                <option @if(old('addr')==null) selected @endif disabled >Select address</option>
                <option @if(old('addr')=="محافظة بيروت") style="background-color: #E0E0E0;" selected @endif >محافظة بيروت</option>
                <option @if(old('addr')=="محافظة جبل لبنان") style="background-color: #E0E0E0;" selected @endif >محافظة جبل لبنان</option>
                <option @if(old('addr')=="محافظة الشمال") style="background-color: #E0E0E0;" selected @endif >محافظة الشمال</option>
                <option @if(old('addr')=="محافظة البقاع") style="background-color: #E0E0E0;" selected @endif >محافظة البقاع</option>
                <option @if(old('addr')== "محافظة الجنوب") style="background-color: #E0E0E0;" selected @endif >محافظة الجنوب</option>
              </select>
            </div>
            @error('addr')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
            <div class="input-group mb-1">
              <input type="text" placeholder="Enter medical center full address" value="{{old('fulladdr')}}"  name="fulladdr" class="form-control mr-1">
            </div>
            @error('fulladdr')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
              <div class="input-group mb-1">
                <input type="text" placeholder="Enter medical center phone number" value="{{old('phone')}}"  name="phone" class="form-control mr-1">
              </div>
            @error('phone')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
                <div class="input-group mb-1">
                  <input type="text" placeholder="Enter medical center fax"  value="{{old('fax')}}" name="fax" class="form-control mr-1">
                </div>
            @error('fax')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>

        </div>
      </div>
    </div>
  </div>


@endsection
