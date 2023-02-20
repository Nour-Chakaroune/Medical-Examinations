@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Waiting Medical Examinations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Medical Examinations</li>
              <li class="breadcrumb-item active">Waiting</li>
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
                    <th>Medical Center</th>
                    <th style="width: 100px">Affiliate &#x2116;</th>
                    <th style="width: 90px">Beneficiary</th>
                    <th>Prescribed Medical Tests</th>
                    <th style="width: 80px">Last same</th>
                    <th style="width: 80px">Date</th>
                    <th>Prescription</th>
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
                      <a type="button" href="/task/waiting/last/{{ $task->id }}" class="btn btn-primary">
                        View
                      </a>
                      </td>
                      <td>{{  date( 'd/m/Y',  strtotime($task->date)) }}</td>
                      <td>
                        <button title="View" type="button" class="btn btn-outline-primary"   data-toggle="modal" data-target="#view{{ $task->id }}">
                            <i class="fas fa-image"></i></button>
                    </td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">

                            <a href="/user/accepted/{{ $task->id }}">
                            <button title="Accepted" class="btn btn-outline-success" type="button" value="{{ $task->id }}" style="width: 50px"><i class="fas fa-check"></i></button>
                                </a>
                            {{-- <a href="/user/rejected/{{ $task->id }}"> --}}
                            <button title="Returned" class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#dlt{{ $task->id }}" style="width: 50px"><i class="fas fa-times"></i></button>
                            {{-- </a> --}}
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

                      {{-- Returned --}}
                      <div class="modal fade" id="dlt{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Return</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route('returnonline')}}" method="POST">
                                {{ csrf_field() }}
                            <div class="modal-body">
                            <h6 style="font-family: Times New Romane">Please specify the reason for the return*</h6>
                            <textarea name="reason" class="form-control" rows ="4" required></textarea>
                            </div>
                            <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-success" data-dismiss="modal">Discared</button> --}}
                            {{-- <button title="Rejected" class="btn btn-primary" type="submit" value="{{ $task->id }}" name="id">Save</button> --}}
                            <div>
                                <button title="Rejected" class="btn btn-primary" type="submit" value="{{ $task->id }}" name="id" id="returned">Save</button>
                                <button class="btn btn-primary" type="button" disabled hidden id="spin">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    </tr>

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


<Script>
  setTimeout(function(){
    $('.alert').alert('close');
  },3000)

  window.onload=function(){
    $(".select2").select2();
  };
</script>

<script>
    $( document ).ready(function() {
        $("form").submit(function(){
            // $("#signup").prop( "disabled", true );
            $("#returned").prop( "hidden", true );
            $("#spin").prop( "hidden", false );
        });
    });
</script>

@endsection
