@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Accepted Medical Examinations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Medical Examinations</li>
                <li class="breadcrumb-item active">Accepted</li>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">


            </div>

            <div class="card">
              <div class="card-body filterable">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Medical Center</th>
                    <th style="width: 100px">Affiliate &#x2116;</th>
                    <th>Beneficiary</th>
                    <th>Prescribed Medical Tests</th>
                    <th>Date</th>
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
                      <th><input type="text" class="form-control" placeholder="Date"></th>
                      <th><input type="text" class="form-control" placeholder="Checked By"></th>
                      <th></th>
                    </tr>
                    </tfoot>
                  <tbody>
                    <?php $i = 0 ?>
                    @foreach ($task as $key=>$task)
                    <?php $i++ ?>
                    @if($task->Status=='Accepted')
                    <tr>
                      <td>{{ $i }}</td>
                      <td>{{ $task->getlabmed->namee }}</td>
                      <td>{{ $task->getCustomer->serial }}</td>
                      <td>{{ $task->getBeneficiaryname->NAME }}</td>
                      <td>{{ $task->type }}</td>
                      <td>{{ date( 'd/m/Y',  strtotime($task->created_at)) }}</td>
                      <td>Dr. {{$task->getUser->fullname}}</td>
                      <td><a href="/task/accepted/print/{{ $task->id }}" class="btn btn-outline-primary"><i class="fas fa-print"></i></a></td>
                    </tr>
                    @endif
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
