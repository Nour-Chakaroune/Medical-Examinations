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
    <script>
        $(document).ready(function(){
            $("#role").change(function(){
               let stat=$.inArray('4',$("#role").val())>=0;
                    $("#number").prop( "readonly", !stat );
                    if(stat == false)
                        $("#number").val('');
            });
        });
        $( document ).ready(function() {
            let stat=$.inArray('4',$("#role").val())>=0;
                    $("#number").prop( "readonly", !stat );
        });
    </script>



<div class="content-wrapper"  style="background-color: white !important;margin-bottom:5%">
<div align="center" class="">
<div class="card card-default" data-select2-id="33" style="width: 50%">
    <div class="card-header">
      <h3 class="card-title">Registration</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body" data-select2-id="36">
        <form action="{{ route('addNewUser') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" placeholder="Full name" id="name" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger" align="left">{{$message}}</span>
            @enderror
            </div>

            <div class="form-group">
                <input type="text" placeholder="User name" id="username" class="form-control" name="username" value="{{ old('username') }}">
                @error('username')
                <span class="text-danger" align="left">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" placeholder="Email" id="email" class="form-control" name="email" value="{{ old('email') }}">
                @error('email')
                <span class="text-danger" align="left">{{$message}}</span>
            @enderror
            </div>

            <div class="form-group">
                <input type="text" placeholder="Phone" id="phone" class="form-control" name="phone" value="{{ old('phone') }}">
                @error('phone')
                <span class="text-danger" align="left">{{$message}}</span>
            @enderror
            </div>

            <div class="form-group">
                <select class="form-control select2 form " id="role" name="role[]" multiple data-placeholder="Select roles" style="width: 100%;">
                  @foreach ($roles as $key)
                      <option value="{{ $key->id }}" {{ (collect(old('role'))->contains($key->id)) ? 'selected':'' }} >{{ $key->role }}</option>
                  @endforeach
                </select>
                @error('role')
                <span class="text-danger" align="left">{{$message}}</span>
            @enderror
            </div>

            <div class="form-group">
                <input type="text" placeholder="Serial number" id="number" class="form-control" name="number" readonly value="{{ old('number') }}">
                @error('number')
                <span class="text-danger" align="left">{{$message}}</span>
            @enderror
            </div>

            <div class="form-group">
                <input type="text" placeholder="Password" id="password" class="form-control" name="password" value="{{ old('password') }}">
                @error('password')
                <span class="text-danger" align="left">{{$message}}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" id="signup">Sign up</button>
                <button class="btn btn-primary" type="button" disabled hidden id="spin">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </form>


    </div>

  </div>
</div>
</div>
<script>
    $( document ).ready(function() {
        $("form").submit(function(){
            // $("#signup").prop( "disabled", true );
            $("#signup").prop( "hidden", true );
            $("#spin").prop( "hidden", false );
        });
    });
</script>
@endsection



