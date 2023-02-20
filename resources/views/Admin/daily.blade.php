@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daily Medical Examinations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Medical Examinations</li>
                <li class="breadcrumb-item active">Daily</li>
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
                <div class="col-sm-6">
                    <h3 style="color:#0096FF">Pending</h3>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Medical Center</th>
                    <th>Affiliate &#x2116;</th>
                    <th>Beneficiary</th>
                    <th>Prescribed Medical Tests</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tfoot style="display: table-header-group">
                    <tr class="filters">
                      <th></th>
                      <th><input type="text" class="form-control" placeholder="Medical center"></th>
                      <th><input type="text" class="form-control" placeholder="Affiliate &#x2116;"></th>
                      <th><input type="text" class="form-control" placeholder="Beneficiary"></th>
                      <th><input type="text" class="form-control" placeholder="Prescribed Medical Tests"></th>
                      <th><input type="text" class="form-control" placeholder="Date"></th>
                    </tr>
                    </tfoot>
                  <tbody>
                    <?php $i = 0 ?>
                    @foreach ($requested as $key=>$req)
                    <?php $i++ ?>
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $req->getpendinglab->namee }}</td>
                      <td>{{ $req->getcustomerpending->serial }}</td>
                      <td>{{ $req->getpendingbenef->NAME }}</td>
                      <td>
                        <select class="form-control select2 form" name="labmed" multiple disabled style="width: 100%;">
                          @foreach (json_decode($req->type) as $key1)
                          <option selected>{{ $key1 }}</option>
                          @endforeach
                      </select>
                      </td>
                      {{-- <td>Today at {{ date( 'h:m:s',  strtotime($req->created_at)) }}</td> --}}
                      <td>Today at {{$req->created_at}}</td>
                    </tr>
                    @endforeach
                  </tbody>

                </table>
                <br><br>
                <div class="col-sm-6">
                    <h3 style="color:#0096FF">Verified</h3>
                </div>
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Medical Center</th>
                      <th>Affiliate &#x2116;</th>
                      <th>Beneficiary</th>
                      <th>Prescribed Medical Tests</th>
                      <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $i = 0 ?>
                      @foreach ($task as $key=>$task)
                      <?php $i++ ?>
                      <tr class="table @if($task->Status=='Accepted') table-success @elseif($task->Status=='Rejected') table-danger @endif">
                        <td>{{ $i }}</td>
                        <td>{{ $task->getlabmed->namee }}</td>
                        <td>{{ $task->cust }}</td>
                        <td>{{ $task->getbeneficiaryname->NAME }}</td>
                        <td>{{ $task->type }}</td>
                        {{-- <td>Today at {{ date( 'h:m:s',  strtotime($task->created_at)) }}</td> --}}
                        <td>Today at {{$task->created_at}}</td>
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
