<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{config('app.name')}}</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/fonts.googleapis.com.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-part2.min.css')}}" class="ace-main-stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-skins.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.min.css')}}"/>
    <script src="{{asset('assets/js/ace-extra.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" class="ace-main-stylesheet" id="main-ace-style"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('libs')}}/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs')}}/datatables.net-bs4/css/responsive.dataTables.min.css">

    <STYLE>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: white !important;
        }
        .input-group {
            position: relative;
            display: flex;
            flex-wrap: nowrap;
            align-items: stretch;
            width: 100%;
        }
        .dt-button{
            background-image: none!important;
            border: 1px solid #FFF;
            border-radius: 0;
            padding: 5px 20px;
            border-radius: 5px;
            box-shadow: none!important;
            -webkit-transition: background-color .15s,border-color .15s,opacity .15s;
            -o-transition: background-color .15s,border-color .15s,opacity .15s;
            transition: background-color .15s,border-color .15s,opacity .15s;
            vertical-align: middle;
            margin: 0;
            position: relative;
        }
        table{padding: 0px !important}
        table th, table td{
            padding: 2px 6px !important;
            font-size: smaller !important;
        }
        .table td{
            border-bottom: 1px  solid  #f1f1f1 !important;
        }
        .nav li {
            display: block;
            width: 100% !important;
        }
        .dropdown-toggle:after {
            display: none;
        }
    </STYLE>
    @php
        $bg1 = \App\Http\Controllers\HomeController::getColor('background_color_1');
        $bg2 = \App\Http\Controllers\HomeController::getColor('background_color_2');
        $bg3 = \App\Http\Controllers\HomeController::getColor('background_color_3');
    @endphp
</head>

<body class="no-skin">
    <div class="container-fluid" style="background-color: white;">
        @if(!isset($lhead))
            <img src="{{\App\Helpers\Helpers::instance()->getHeader()}}" class="w-100 h-auto">
        @endif
        <div class="text-center text-black h3 py-2 text-capitalize">{{$title ?? ''}}</div>
        @yield('section')
    </div>
    <script src="{{asset('assets/js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{asset('assets/js/ace.min.js')}}"></script>

    <script src="{{asset('libs')}}/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('libs')}}/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

    <script>
        $(function () {
            $('.table , .adv-table table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        text: 'Download PDF',
                        extend: 'pdfHtml5',
                        message: '',
                        orientation: 'portrait',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function (doc) {
                            doc.pageMargins = [10,10,10,10];
                            doc.defaultStyle.fontSize = 7;
                            doc.styles.tableHeader.fontSize = 7;
                            doc.styles.title.fontSize = 9;
                            doc.content[0].text = doc.content[0].text.trim();

                            doc['footer']=(function(page, pages) {
                                return {
                                    columns: [
                                        '{{ $title ?? `` }}',
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                            // Styling the table: create style object
                            var objLayout = {};
                            // Horizontal line thickness
                            objLayout['hLineWidth'] = function(i) { return .5; };
                            // Vertikal line thickness
                            objLayout['vLineWidth'] = function(i) { return .5; };
                            // Horizontal line color
                            objLayout['hLineColor'] = function(i) { return '#aaa'; };
                            // Vertical line color
                            objLayout['vLineColor'] = function(i) { return '#aaa'; };
                            // Left padding of the cell
                            objLayout['paddingLeft'] = function(i) { return 4; };
                            // Right padding of the cell
                            objLayout['paddingRight'] = function(i) { return 4; };
                            // Inject the object in the document
                            doc.content[1].layout = objLayout;
                        }
                    }

                ],
                info:     false,
                searching: true,
                ordering : false
            });

        });

    </script>

    <script src="{{ asset('libs')}}/datatables.net/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('libs')}}/datatables.net/js/jszip.min.js"></script>
    <script src="{{ asset('libs')}}/datatables.net/js/pdfmake.min.js"></script>
    <script src="{{ asset('libs')}}/datatables.net/js/vfs_fonts.js"></script>
    <script src="{{ asset('libs')}}/datatables.net/js/buttons.html5.min.js"></script>

    <script>
        (function($){
            'use strict';
            $(window).on('load', function () {
                if ($(".pre-loader").length > 0)
                {
                    $(".pre-loader").fadeOut("slow");
                }
            });
        })(jQuery)
    </script>
    @yield('script')
</body>
</html>