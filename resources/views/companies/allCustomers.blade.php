@extends('main')
@section('image')
<img src={{ asset("assets/img/sora.jpg") }} class="navbar-logo" alt="logo">
@endsection
@section('page')
جميع العملاء
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
    #html5-extension td {
    font-size: 15px;
    font-weight: bold;
    text-align: center
    }

    #html5-extension th {
    text-align: center
    }

    .navbar-expand-sm {
    justify-content: center
    }
</style>
@endsection




@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        @if (\Session::has('danger'))
        <div class="alert alert-danger">
            <ul>
                <li style="list-style: none;font-size:25px;text-align: center">{!! \Session::get('danger') !!}</li>
            </ul>
        </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li style="list-style: none;font-size:25px;text-align: center">{!! \Session::get('success') !!}</li>
            </ul>
        </div>
        @endif
        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th> رقم التسجيل الضريبى</th>
                    <th>العنوان</th>
                    <th>تعديل</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)

                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->BetakaDriba }}</td>
                    <td>{{ $customer->AddrCo }}</td>
                    <td><a href="{{ route('editCustomer',$customer->id) }}" class="btn btn-success">تعديل</a></td>
                    <td>
                        <form action="{{ route('deleteCustomer',$customer->id ) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('هل انت متأكد من مسح العميل؟');">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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
<script src="plugins/table/datatable/datatables.js"></script>
<!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
<script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
<script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
<script>
    $('#html5-extension').DataTable( {
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'csv', className: 'btn btn-sm' },
                    { extend: 'excel', className: 'btn btn-sm' },
                    { extend: 'print', className: 'btn btn-sm' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        } );
</script>






@endsection
