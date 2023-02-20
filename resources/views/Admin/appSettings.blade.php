@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h3> Settings </h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Settings</li>
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
                <h2  style="color:#0096FF">Mail</h2> <hr>

                            <form action="{{route('updatesettings')}}" method="POST">
                              {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>USERNAME</label>
                                    <input type="text"  value="{{$mail->MAIL_USERNAME}}"  name="user_name" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('user_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>PASSWORD</label>
                                    <input type="text"  value="{{$mail->MAIL_PASSWORD}}"  name="password" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>FROM ADDRESS</label>
                                    <input type="text"  value="{{$mail->MAIL_FROM_ADDRESS}}"  name="from_address" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('from_address')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>FROM NAME</label>
                                    <input type="text"  value="{{$mail->MAIL_FROM_NAME}}"  name="from_name" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('from_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>MAILER</label>
                                    <input type="text"  value="{{$mail->MAIL_MAILER}}"  name="mailer" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('mailer')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>HOST</label>
                                    <input type="text"  value="{{$mail->MAIL_HOST}}"  name="host" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('host')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>PORT</label>
                                    <input type="text"  value="{{$mail->MAIL_PORT}}"  name="port" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('port')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>ENCRYPTION</label>
                                    <input type="text"  value="{{$mail->MAIL_ENCRYPTION}}"  name="encryption" class="form-control shadow-sm p-3 mb-1 bg-white rounded">
                                    @error('encryption')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>


                                <div class="modal-footer">
                                <button type="submit" value="{{ $mail->id }}" name="id" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>



              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection
