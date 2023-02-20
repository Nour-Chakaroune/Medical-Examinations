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
            <a href="" class="nav-link" id="addtestt" data-toggle="modal" data-target="#addtest">
                <i class="fas fa-plus-circle"></i> Add New Test </a>
            </h3>
          </div>
          <div class="col-sm-9">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Medical Tests</li>
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
          timer: 3500
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
                    <th>Name</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tfoot style="display: table-header-group">
                    <tr class="filters">
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Name"></th>
                      <th><input type="text" class="form-control" placeholder="Type"></th>
                      <th></th>
                    </tr>
                    </tfoot>
                  <tbody>
                    <?php $i = 0 ?>
                    @foreach ($tests as $key=>$task)
                    <?php $i++ ?>
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $task->name }}</td>
                      <td>{{ $task->type }}</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Medical Test</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('edittest') }}" method="POST">
                              {{ csrf_field() }}
                            <label>Name</label>
                                <div class="form-group">
                                    <input type="text"  value="{{$task->name}}"  name="edttestname" class="form-control mr-1" id="testname">
                                </div>

                            <label>Type</label>
                                <div class="input-group mb-1">
                                    <select name="edttype" class="form-control">
                                      <option @if($task->type=="Laboratory") style="background-color: #E0E0E0;" selected @endif value="Laboratory">Laboratory</option>
                                      <option @if($task->type=="RadioOncology") style="background-color: #E0E0E0;" selected @endif value="RadioOncology">RadioOncology</option>
                                      <option @if($task->type=="X-Ray") style="background-color: #E0E0E0;" selected @endif value="X-Ray">X-Ray</option>
                                      <option @if($task->type=="Anatomic Pathology") style="background-color: #E0E0E0;" selected @endif value="Anatomic Pathology">Anatomic Pathology</option>
                                    </select>
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
                            Are you sure you want delete this test?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <a href="/test/delete/{{ $task->id }}" class="btn btn-danger">Yes</a>
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
  <div class="modal fade" id="addtest" tabindex="-1" role="dialog" aria-labelledby="addtest" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add new test</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('addNewTest') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
            <div class="input-group mb-1">
              <input type="text" placeholder="Enter test name" value="{{old('testname')}}" name="testname" class="form-control mr-1">
            </div>
              @error('testname')
              <span class="text-danger" align="left">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <div class="input-group mb-1">
                <select name="type" class="form-control select2 form" style="width: 100%;">
                  <option @if(old('type')==null)  selected @endif disabled>Select type</option>
                  <option @if(old('type')=="Laboratory") style="background-color: #E0E0E0;" selected @endif value="Laboratory">Laboratory</option>
                  <option @if(old('type')=="RadioOncology") style="background-color: #E0E0E0;" selected @endif value="RadioOncology">RadioOncology</option>
                  <option @if(old('type')=="X-Ray") style="background-color: #E0E0E0;" selected @endif value="X-Ray">X-Ray</option>
                  <option @if(old('type')=="Anatomic Pathology") style="background-color: #E0E0E0;" selected @endif value="Anatomic Pathology">Anatomic Pathology</option>
                </select>
              </div>
                @error('type')
                <span class="text-danger" align="left">{{$message}}</span>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>





@endsection
