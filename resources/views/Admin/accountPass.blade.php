@extends('layouts.master')
@section('content')
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
<div class="content-wrapper"  style="background-color: white !important;margin-bottom:5%">
<div align="center" class="">
<div class="card card-default" data-select2-id="33" style="width: 50%">
    <div class="card-header">
      <h3 class="card-title">Update Password</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    @if ($errors->any())
    <div class="alert fade show"
        style="background-color: #FFCCCB;color:#8B0000;font-family:times new roman;" role="alert" align="center">
        {{ $errors->first() }}
    </div>
    @endif
  <div class="card-body">
    <form action="{{ route('changepass') }}" method="POST" align="left">
        @csrf
        <label>Enter old password</label>
        <div class="form-group">
            <input type="password" placeholder="Enter old password" class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="oldpass" required>
        </div>
        <br>
        <label>Enter new password</label>
        <div class="form-group">
            <input type="password" placeholder="Enter new password" class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="newpass" required>
        </div>
        <br>
        <label>Confirm new password</label>
        <div class="form-group">
            <input type="password" placeholder="Confirm new password" class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="confirmpass" required>
        </div>
        <br>
        <div align="center">
            <button type="submit" value="{{Auth::User()->id}}" class="btn btn-primary">Change Password</button>
        </div>
    </form>
  </div>

  </div>
</div>
</div>
@endsection
