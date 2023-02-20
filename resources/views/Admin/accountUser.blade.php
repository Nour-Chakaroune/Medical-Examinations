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
      <h3 class="card-title">Update Profile</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body" data-select2-id="36">
        <form action="{{route('accountedit')}}" method="POST" align="left">
            @csrf
            <label>Full Name</label>
            <div class="form-group">
                <input type="text"  class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="fullname" value="{{ Auth::User()->fullname }}">
                @error('fullname')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>

            <label>User Name</label>
            <div class="form-group">
                <input type="text"  class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="username" value="{{ Auth::User()->username }}">
                @error('username')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>

            <label>Email</label>
            <div class="form-group">
                <input type="text" class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="email" value="{{ Auth::User()->email}}">
                @error('email')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <label>Phone</label>
            <div class="form-group">
                <input type="text" class="form-control shadow-sm p-3 mb-1 bg-white rounded" name="phone" value="{{ Auth::User()->phone }}">
                @error('phone')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>

            <label>Serial Number</label>
            <div class="form-group">
                <input type="text" class="form-control shadow-sm p-3 mb-1 rounded" name="number" value="{{ Auth::User()->number }}" ReadOnly>
                @error('number')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            {{-- <label>Reset Password </label>
            <div class="form-group">
                <input type="text"  class="form-control" name="password" placeholder="Enter new password">
            </div> --}}
            <div align="center">
                <button type="submit" value="{{Auth::User()->id}}" class="btn btn-primary">Save Change</button>
            </div>
        </form>
    </div>

  </div>
</div>
</div>
@endsection
