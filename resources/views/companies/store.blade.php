
@extends('main')
@section('image')
<img src={{ asset("assets/img/sora.jpg") }} class="navbar-logo" alt="logo">
@endsection
@section('page')
انشاء فاتورة جديدة
@endsection
@section('head')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<title>الفاتورة الإلكترونية </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
<link href="../assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="../assets/js/loader.js"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
<link href="../assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="../assets/js/loader.js"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />

<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">



{{-- <script src="{{ asset('assets/js/invoice.js') }}"></script> --}}

<style>
    th,
    td {
        padding: 5px;
        text-align: center;
    }

    .borderNone {
        border: none
    }

    .borderNone:focus {
        outline: none;
    }

    .online-actions {
        display: none;
    }

    .navbar-expand-sm {
        justify-content: center
    }

    input[type="number"] {
        width: 150;
        text-align: center
    }

    hr {
        border: 4px solid white;
    }
</style>
@endsection




@section('content')
<form action="{{ route('storeCompany') }}" method="POST">
    @csrf
    @method('post')
<div class="form-group" style="text-align: center">
    <label for="exampleFormControlInput1">اسم العميل </label>
    <input style="text-align: center;margin:auto" type="text" class="form-control col-6" id="exampleFormControlInput1" name="name" required placeholder="اسم العميل">

    <label for="exampleFormControlInput1"> رقم البطاقة الضريبية </label>
    <input  style="text-align: center;margin:auto" type="text" class="form-control col-6" id="exampleFormControlInput1" name="BetakaDriba" required placeholder="رقم البطاقة الضريبية">


    <label for="exampleFormControlInput1"> عنوان الشركة </label>
    <input  style="text-align: center;margin:auto" type="text" class="form-control col-6" id="exampleFormControlInput1" name="AddrCo" required placeholder="عنوان العميل">

</div>
<div style="text-align: center">

    <input type="submit" value="اضافة العميل" class="mb-4 btn btn-primary">
</div>
</form>

@endsection






@section('js')
<script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#receiverName").select2({
        dir: "rtl"
    });

</script>
<script src="../bootstrap/js/popper.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/app.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });

</script>
<script src="../assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<script src="../plugins/dropify/dropify.min.js"></script>
<script src="../plugins/fullcalendar/flatpickr.js"></script>
<script src="../assets/js/apps/invoice-add.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}





@endsection


