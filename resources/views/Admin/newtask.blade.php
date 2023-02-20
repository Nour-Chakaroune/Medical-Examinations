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
      <h3 class="card-title">Add New Task</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body" data-select2-id="32">
        <form method="POST" action="{{ route('check') }}">
            <div class="form-group">
                <div class="input-group mb-3">
                    @csrf
                    <input type="text" placeholder="Enter serial number" value="{{ old('serial') }}"  name="serial" class="form-control mr-1" id="serial">
                    <button class="btn btn-outline-success" type="submit">Check</button>
                </div>
            @error('serial')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        </form>
        <form action="{{ route('setnewtask') }}" enctype="multipart/form-data" method="POST" >
            @csrf
        <input type="hidden" name="serial" value="{{ old('serial') }}">
        <div class="form-group">
            <select class="form-control select2 form" name="benef" disabled data-placeholder="Select beneficiary" style="width: 100%;">
                <option value="" @if(old('benef')==null) selected @endif disabled>Select beneficiary</option>
                @foreach (App\Models\Beneficiary::where('Teacher_ID',old('serial'))->orderBy('NAME')->get() as $key1=>$req1)
                    <option value="{{ $req1->id }}" {{ (collect(old('benef'))->contains($req1->id)) ? 'selected':'' }}>{{ $req1->NAME }}</option>
                @endforeach
            </select>
            @error('benef')
            <span class="text-danger" align="left">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <select class="form-control select2 form " name="test[]" disabled multiple data-placeholder="Select tests" style="width: 100%;">
              @foreach ($tests as $key)
                  <option value="{{ $key->name }}" {{ (collect(old('test'))->contains($key->name)) ? 'selected':'' }} >{{ $key->name }}</option>
              @endforeach
            </select>
            @error('test')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <select class="form-control select2 form" name="labmed" disabled data-placeholder="Select medical center" style="width: 100%;">
                <option value="" @if (old('labmed')==null) selected @endif  disabled>Select Medical Center</option>
                @foreach ($labmed as $key)
                  <option value="{{ $key->id }}" {{ (collect(old('labmed'))->contains($key->id)) ? 'selected':'' }}>{{ $key->namee }}</option>
              @endforeach
            </select>
            @error('labmed')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
              <div class="input-group date reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input form" value="{{ old('date') }}" disabled placeholder="Date" name="date" data-target=".reservationdate"/>
                  <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
              </div>
              @error('date')
              <span class="text-danger">{{$message}}</span>
              @enderror
        </div>

        <div class="form-group">
            <div class="row form-group">
                <div class="col-lg-5">
            <input type="file" accept=".jpg,.png,.jpeg" class="form-control-file form" disabled name="image">
            </div></div>
            @error('image')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>


          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

  </div>
</div>
</div>
<script>
  window.onload = function() {
    if(document.getElementById('serial').value!=""){
      $(".form").prop('disabled',false);
    }
  };

  window.onload=function(){
    if(document.getElementById('serial').value!=""){
        $(".form").prop('disabled',false);
        $("select").select2();
    }
  };
  </script>
@endsection
