<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print task</title>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<style>
@media print{
    .noprint{
        display:none;
    }
 }
</style>
<body>
        <div id="prt" style="margin: 10px">
        <div align="center">
        <img src="{{ asset('img/lo_go.png') }}" width="150px" height="150px">
        </div><br>
        @if(Route::currentRouteName()=='printpending')
        @foreach ($task as $key)
        <div class="float-start" dir="rlt">
            <label>{{ $key->serial }}</label>
            <label>: رقم الانتساب</label><br>
            <label>{{ $key->getpendingbenef->NAME }} @if($key->getpendingbenef->PID==0)(Himself) @elseif($key->getpendingbenef->PID==1) (Parents) @elseif($key->getpendingbenef->PID==2) (Wife or husband) @elseif($key->getpendingbenef->PID>=3) (Son or daugther) @endif</label>
            <label>: إسم المريض</label><br>
            <label>@if($key->getpendingbenef->PID==0) 85% @elseif($key->getpendingbenef->PID==1) 60% @elseif($key->getpendingbenef->PID==2) 85% @elseif($key->getpendingbenef->PID>=3) 85% @endif</label>
            <label>: نسبة التغطية</label><br>
        </div>
        <div class="float-end"  dir="rtl">

            <label>رقم المعاملة:</label>
            <label><script>document.write(new Date().getFullYear())</script>/{{ $key->id }}</label><br>
            <label>تاريخ المعاملة :</label>
            <label>{{ date( 'd F Y',  strtotime($key->created_at)) }}</label><br>
            <label>مركز الفحوصات :</label>
            <label>{{ $key->getpendinglab->namee }}</label>
            <br>
        </div>
        @endforeach
        <br><br>
        @foreach ($task as $key)
        <table class="table table-bordered" style="width: 50%;margin-top:50px" align="center">
            <thead style="text-align: center">
                <th>Name of test</th>
                <th>Approved</th>
                <th>Not approved</th>
            </thead>
            <tbody>
                @foreach (json_decode($key->type) as $test)
                <tr>
                    <td align="center">{{ $test }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div align="center">
	<textarea  rows=6 style="width:70%" class="form-control"></textarea></div> <br>
        <div align="center"><button class="btn btn-outline-primary" onclick="pr()"><box-icon type='solid' name='printer'></box-icon></button></align>
        </div>
        </div>
        <script>
            function pr(){
            window.print();
        }
        </script>
        @endforeach
        @elseif(Route::currentRouteName()=='printaccepted')
        <div class="float-start" dir="rlt">
            <label>{{ $tsk->cust }}</label>
            <label>: رقم الانتساب</label><br>
            <label>{{ $tsk->getBeneficiaryname->NAME }} @if($tsk->getbeneficiaryname->PID==0)(Himself) @elseif($tsk->getbeneficiaryname->PID==1) (Parents) @elseif($tsk->getbeneficiaryname->PID==2) (Wife or husband) @elseif($tsk->getbeneficiaryname->PID>=3) (Son or daugther) @endif</label>
            <label>: إسم المريض</label><br>
            <label>@if($tsk->getbeneficiaryname->PID==0) 85% @elseif($tsk->getbeneficiaryname->PID==1) 60% @elseif($tsk->getbeneficiaryname->PID==2) 85% @elseif($tsk->getbeneficiaryname->PID>=3) 85% @endif</label>
            <label>: نسبة التغطية</label><br>
        </div>
        <div class="float-end"  dir="rtl">

            <label>رقم المعاملة:</label>
            <label><script>document.write(new Date().getFullYear())</script>/{{ $tsk->id }}</label><br>
            <label>تاريخ المعاملة :</label>
            <label>{{ date( 'd/m/Y',  strtotime($tsk->created_at)) }}</label><br>
            <label>مركز الفحوصات :</label>
            <label>{{ $tsk->getlabmed->namee }}</label>
            <br>
        </div>
        <br><br>
        <table class="table table-bordered" style="width: 50%;margin-top:50px" align="center">
            <thead style="text-align: center">
                <th>Name of test</th>
                <th>Approved</th>
                <th>Not approved</th>
            </thead>
            <tbody>
                @foreach ($task as $test)
                <tr>
                    <td align="center">{{ $test->type }}</td>
                    <td align="center" style="font-size: 20px">@if($test->Status=='Accepted') X @endif</td>
                    <td align="center" style="font-size: 20px">@if($test->Status=='Rejected') X @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div align="center">
            <strong dir="rtl">*الفحوصات الموافق عليها بحسب لائحة الضمان الإجتماعي*</strong>
        </div>
        <br>
        <div align="center">
        <h6><i>Checked by: Dr. {{$tsk->getUser->fullname}}</i></h6> <br>
        </div>
        <div id="sig" class="mt-3"></div>
        <div align="center" class="noprint">
        {{-- <select class="form-control mt-5" id="dc" style="width:10%">
        <option value="dc1">Doctor 1</option>
        <option value="dc2">Doctor 2</option>
        <option value="dc3">Doctor 3</option>
        </select> --}}


        <button class="btn btn-outline-primary" onclick="prt()"><box-icon type='solid' name='printer'></box-icon></button>
        </div>
        @endif
        </div>
        <script>
            function prt(){
            // var a=document.getElementById("dc").value;
            // if(a=="dc1") document.getElementById("sig").innerHTML="Doctor 1 signature"
            // if(a=="dc2") document.getElementById("sig").innerHTML="Doctor 2 signature"
            // if(a=="dc3") document.getElementById("sig").innerHTML="Doctor 3 signature"
            window.print();
        }
        </script>
</body>
</html>
