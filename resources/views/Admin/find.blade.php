@extends('layouts.master')
@section('content')
{{-- @inject('task', 'App\Models\Task') --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Find Medical Examinations By Dates</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Medical Examinations</li>
                <li class="breadcrumb-item active">Find</li>
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
                  <form action="/task/find" method="POST">
                    @csrf
                  <div class="row">
                      <div class="col">
                        <div class="input-group date" id="fromdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input form" value="{{ old('fromdate') }}" placeholder="From Date" name="fromdate" data-target="#fromdate"/>
                            <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="input-group date  ml-5" id="todate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input form" value="{{ old('todate') }}" placeholder="To Date" name="todate" data-target="#todate"/>
                            <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                      </div>
                      <div class="col ml-5"><input type="submit" value="Find" class="btn btn-primary"></div>
                  </div>
                </form>
                <div class="form-group">


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
                    {{-- @foreach ($task::with('getlabmed')->with('getbeneficiaryname')->with('getType')->get() as $key1=>$req1) --}}
                    @if(Session::get('task2'))
                        @foreach(Session::get('task2') as $key1=>$req1)
                            <?php $i++ ?>
                            <tr @if($req1->Status=='Accepted')
                            class="table-success"
                            @else
                            class="table-danger"
                            @endif>
                            <td>{{ $i }}</td>
                            <td>{{ $req1->getlabmed->namee }}</td>
                            <td>{{ $req1->getbeneficiaryname->Teacher_ID }}</td>
                            <td>{{ $req1->getbeneficiaryname->NAME }}</td>
                            <td>{{ $req1->type }}</td>
                            <td>{{ date( 'd/m/Y',  strtotime($req1->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach($task as $key1=>$req1)
                            <?php $i++ ?>
                            <tr @if($req1->Status=='Accepted')
                            class="table-success"
                            @else
                            class="table-danger"
                            @endif>
                            <td>{{ $i }}</td>
                            <td>{{ $req1->getlabmed->namee }}</td>
                            <td>{{ $req1->getbeneficiaryname->Teacher_ID }}</td>
                            <td>{{ $req1->getbeneficiaryname->NAME }}</td>
                            <td>{{ $req1->type }}</td>
                            <td>{{ date( 'd/m/Y',  strtotime($req1->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @endif

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
