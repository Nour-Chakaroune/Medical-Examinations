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

        <img src="{{ asset('img/lo_go.png') }}" class = "img-fluid center-block d-block "
            style="width:30%;margin-top:7%;margin-left:39%" alt="description of myimage">
    {{-- style="display: block; margin-left: 620px; margin-right: auto;width:35%;
    height: auto;margin-top:30px;" mx-auto --}}


@endsection
