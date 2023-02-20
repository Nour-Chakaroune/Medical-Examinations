@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pending Medical Examinations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Medical Examinations</li>
                <li class="breadcrumb-item active">Pending</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if(Session::get('err'))
    {{-- <div  align="center">
    <div class="alert alert-success bg-gradient-success alert-dismissible fade show" role="alert"style="width: 50%">
      {{ Session::get('err') }}
    </div>
  </div> --}}
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <!-- /.card-header -->

              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body filterable">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th style="width: 13%">Medical Center</th>
                    <th >Affiliate &#x2116;</th>
                    <th >Beneficiary</th>
                    <th style="width: 18%">Prescribed Medical Tests</th>
                    <th style="width: 80px">Last same</th>
                    <th style="width: 80px">Date</th>
                    <th>Prescription</th>
                    <th>Checked By</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tfoot style="display: table-header-group">
                    <tr class="filters">
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Medical center"></th>
                      <th><input type="text" class="form-control" placeholder="Affiliate &#x2116;"></th>
                      <th><input type="text" class="form-control" placeholder="Beneficiary"></th>
                      <th><input type="text" class="form-control" placeholder="Prescribed Medical Tests"></th>
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Date"></th>
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Checked By"></th>
                      <th></th>
                    </tr>
                    </tfoot>
                  <tbody>

                    <?php $i = 0 ?>
                    @foreach ($task as $key=>$task)
                    <?php $i++ ?>
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $task->getpendinglab->namee }}</td>
                      <td>{{ $task->serial }}</td>
                      <td>{{ $task->getpendingbenef->NAME }}</td>
                      <td>
                        <div class="form-group">
                            <select class="form-control select2 form" name="labmed" multiple disabled style="width: 100%;">
                                @foreach (json_decode($task->type) as $key1)
                                <option selected>{{ $key1 }}</option>
                                @endforeach
                            </select>
                        </div>
                      </td>
                      <td>
                      <a type="button" href="/task/pending/last/{{ $task->id }}" class="btn btn-primary">
                        View
                      </a>
                      </td>
                        <td>{{ date( 'd/m/Y',  strtotime($task->date)) }}</td>
                      <td>
                        <button title="View" type="button" class="btn btn-outline-primary"   data-toggle="modal" data-target="#view{{ $task->id }}">
                            <i class="fas fa-image"></i></button>
                      </td>
                      <td> {{$task->getUser->fullname}} </td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            @if(Session::has('permission.13'))
                                <button title="Edit task" type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#edt{{ $task->id }}"><i class="far fa-edit"></i></button>
                                <button title="Delete task" type="button" class="btn btn-outline-danger"  data-toggle="modal" data-target="#dlt{{ $task->id }}"><i class="far fa-trash-alt"></i></button>
                            @endif
                            @if(Session::has('permission.14'))
                                <button title="Result" type="button" class="btn btn-outline-info"   data-toggle="modal" data-target="#rslt{{ $task->id }}"><i class="fas fa-tasks"></i></i></button>
                            @endif
                                <a title="Print task" href="/task/pending/print/{{ $task->id }}" class="btn btn-outline-primary"><i class="fas fa-print"></i></a>

                        </div>
                            <br><br>

                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <table>
                                @foreach (json_decode($task->type) as $key1)
                                    @foreach (App\Models\Task:: where(['type'=>$key1,'benef'=>$task->getpendingbenef->id ])->get() as $key1=>$req1)
                                        <tr class="table @if($req1->Status =='Accepted') table-success @elseif($req1->Status =='Rejected') table-danger @endif">
                                        <td>{{ $req1->type }}</td>
                                        <td>  {{ $req1->date }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                            </div>


                      </td>

                    </tr>

                    {{-- edit --}}
                    <div class="modal fade" id="edt{{ $task->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('edittask') }}" enctype="multipart/form-data" method="POST">
                              {{ csrf_field() }}
                                <label>Beneficiary</label>
                                <div class="form-group">
                                    <select class="form-control select2 form" name="benef" style="width: 100%;">
                                       @foreach (DB::table('benef')->select('*')->where('Teacher_ID',$task->serial)->get() as $key)
                                           <option value="{{ $key->id }}" @if($key->id==$task->pat) selected @endif>{{ $key->NAME }}</option>
                                       @endforeach
                                    </select>
                                    @error('benef')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <label>Tests</label>
                                <div class="form-group">
                                    <select class="form-control select2 form" name="test[]" multiple style="width: 100%;">
                                        @foreach ($tests as $key)
                                        <option value="{{ $key->name }}"  {{ (collect(json_decode($task->type))->contains($key->name)) ? 'selected':'' }}>{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('test')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <label>Medical center</label>
                                <div class="form-group">
                                    <select class="form-control select2 form" name="labmed" style="width: 100%;">
                                        @foreach ($labmed as $key)
                                        <option value="{{ $key->id }}" @if($key->id==$task->labmed) selected @endif>{{ $key->namee }}</option>
                                        @endforeach
                                    </select>
                                    @error('labmed')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <label>Date</label>
                                <div class="form-group">
                                    <div class="input-group date reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input form" value="{{ $task->date }}" placeholder="Date" name="date" data-target=".reservationdate"/>
                                        <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <label>Upload a new image of the medical examinations if you want to replace the old one &nbsp;</label>
                                   <button title="View Old Image" type="button" class="btn btn-outline-primary"   data-toggle="modal" data-target="#zoom{{ $task->id }}">
                                        <i class="fas fa-image"></i></button>

                                <div class="form group">
                                     <input type="file" accept=".jpg,.png,.jpeg" class="form-control-file" name="image">
                                     @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                        {{-- <div class="row">
                            <div class="col-lg-5">
                                <label>Upload a new image if you want to replace the old one</label>
                                <div class="form-group">
                                    <input type="file" accept=".jpg,.png,.jpeg" class="form-control-file" name="image">
                                </div>
                            </div>
                            <div class="col-lg-6" align="left">
                                <div class="form-group">
                                    <div>
                                        <a href="#" class="pop">
                                            <img title="Click to Zoom " src="{{ "data:image/;base64," .base64_encode( $task->image ) }}" class="img-fluid" width="30%" alt="No Image Uploaded"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" value="{{ $task->id }}" name="id" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                        </div>
                    </div>
                    <!-- Button trigger modal delete -->
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
                            Are you sure you want delete this task?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <a href="/task/pending/delete/{{ $task->id }}" class="btn btn-danger">Yes</a>
                            </div>
                        </div>
                        </div>
                    </div>

                    {{-- result --}}
                    <div class="modal fade" id="rslt{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Give Result</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="/task/pending/result/{{ $task->id }}" method="POST">
                            @csrf
                          <div class="modal-body">
                          <label>Customer</label>
                          <input type="text" readonly class="form-control" value="{{ $task->serial }}">
                          <label>Patient</label>
                          <input type="text" readonly class="form-control"  value="{{ $task->getpendingbenef->NAME }}">
                          <label>Medical Center</label>
                          <input type="text" readonly class="form-control" value="{{ $task->getpendinglab->namee }}">
                          <label>Tests</label>
                          <select class="form-control" disabled id="tst{{ $task->id }}">
                          @foreach (json_decode($task->type) as $test)
                              <option>{{ $test }}</option>
                          @endforeach
                          </select>
                          <div class="row m-3" align="center">
                            <div class="col">
                              <button class="btn btn-success" type="button" onclick="accept{{ $task->id }}()" style="width: 50px"><i class="fas fa-check"></i></button>
                              <button class="btn btn-danger" type="button" onclick="reject{{ $task->id }}()" style="width: 50px"><i class="fas fa-times"></i></button>
                            </div>
                            <script>
                              function accept{{ $task->id }}(){
                                var a = document.getElementById("tst{{ $task->id }}");
                            if(a.value!="")
                            {
                            document.getElementById("acc{{ $task->id }}").innerHTML="* "+a.value+"\n"+document.getElementById("acc{{ $task->id }}").value;
                            a.remove(a.selectedIndex);
                            }
                              }
                              function reject{{ $task->id }}(){
                                var a = document.getElementById("tst{{ $task->id }}");
                            if(a.value!="")
                            {
                            document.getElementById("rej{{ $task->id }}").innerHTML="* "+a.value+"\n"+document.getElementById("rej{{ $task->id }}").value;
                            a.remove(a.selectedIndex);
                            }
                              }
                            </script>
                          </div>
                          <div class="row" align="center">
                            <div class="col">
                              <label>Accepted Tasks</label>
                            </div>
                            <div class="col">
                              <label>Rejected Tasks</label>
                            </div>
                          </div>
                          <div class="row" align="center">
                            <div class="col">
                              <textarea name="acc" id="acc{{ $task->id }}" class="form-control" style="resize: none;background-color:white" readonly cols="40" rows="7"></textarea>
                            </div>
                            <div class="col">
                              <textarea name="rej" id="rej{{ $task->id }}" class="form-control" style="resize: none;background-color:white"  readonly cols="40" rows="7"></textarea>
                            </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                            <button type="button" id="rs{{ $task->id }}" onclick="vald{{ $task->id }}()" class="btn btn-primary">Save changes</button>
                            <button class="btn btn-primary" type="button" disabled hidden id="spin">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                          </div>
                          <script>

                            $( document ).ready(function() {
                                $("form").submit(function(){
                                    $("#rs{{$task->id}}").prop( "hidden", true );
                                    $("#close").prop( "hidden", true );
                                    $("#spin").prop( "hidden", false );
                                });
                          });

                            function vald{{ $task->id }}()
                            {
                              if(document.getElementById('tst{{ $task->id }}').value!=''){
                                    var Toast = Swal.mixin({
                                                                toast: true,
                                                                position: 'top-end',
                                                                showConfirmButton: false,
                                                                timer: 3000
                                                            });
                                        Toast.fire({
                                                    icon: 'warning',
                                                    title: 'Please give result for all test.',
                                                    background: '#f1ee8e',
                                        })
                            }
                            else document.getElementById('rs{{ $task->id }}').setAttribute('type','submit');
                          }


                          </script>
                          </form>
                        </div>
                      </div>
                    </div>
                    {{-- View Image --}}
                    <div class="modal fade" id="view{{ $task->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">View Prescription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            {{ csrf_field() }}
                            <label>Prescribed Medical Tests:</label>
                                <div class="form-group">
                                    <select class="form-control select2 form" name="labmed" multiple disabled style="width: 100%;">
                                        @foreach (json_decode($task->type) as $key1)
                                        <option selected>{{ $key1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label>Uploaded image of the medical examinations:</label>
                                <div class="form-group" align="center">
                                    <img  src="{{ "data:image/" .$task->imageType. ";base64," .base64_encode( $task->image ) }}" class="img-fluid" alt="No Image Uploaded"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- Zoom Image --}}
                    <div class="modal fade" id="zoom{{ $task->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Old image of the medical examinations</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            {{ csrf_field() }}
                                <div class="form-group" align="center">
                                    <img  src="{{ "data:image/" .$task->imageType. ";base64," .base64_encode( $task->image ) }}" class="img-fluid" alt="Try Again"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                  </tbody>

                </table>
                <!-- Button trigger modal -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" data-dismiss="modal">
      <div class="modal-content"  >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body" align="center">
          <img src="" class="imagepreview" class="img-fluid" >
        </div>
      </div>
    </div>
  </div> --}}

<Script>
  setTimeout(function(){
    $('.alert').alert('close');
  },3000)

  window.onload=function(){
    $(".select2").select2();
  };

  $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
    });
</script>


@endsection
