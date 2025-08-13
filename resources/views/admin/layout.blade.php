<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{!! $title ?? '' !!} | {{__('text.app_name')}}</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{url('/')}}/public/assets/css/*.css" />

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

    
    <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script> -->

    <STYLE>
        body {
            font-family: Arial, Helvetica, sans-serif;
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
            padding: 10px;
        }
        .table td{
            border-bottom: 1px  solid  #f1f1f1 !important;
        }
        .nav li {
            display: block;
            word-wrap: break-word;
            min-height: fit-content;
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
    $current_year = \App\Helpers\Helpers::instance()->getCurrentAccademicYear();
@endphp
</head>
<body class="no-skin">
<div class="pre-loader">
    <div class="sk-fading-circle">
        <div class="sk-circle1 sk-circle"></div>
        <div class="sk-circle2 sk-circle"></div>
        <div class="sk-circle3 sk-circle"></div>
        <div class="sk-circle4 sk-circle"></div>
        <div class="sk-circle5 sk-circle"></div>
        <div class="sk-circle6 sk-circle"></div>
        <div class="sk-circle7 sk-circle"></div>
        <div class="sk-circle8 sk-circle"></div>
        <div class="sk-circle9 sk-circle"></div>
        <div class="sk-circle10 sk-circle"></div>
        <div class="sk-circle11 sk-circle"></div>
        <div class="sk-circle12 sk-circle"></div>
    </div>
</div>

<div id="navbar" class="navbar navbar-default  ace-save-state" style="background-color: {{$bg1}};">
    <div class="navbar-container w-100 ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left display" id="menu-toggler"
                data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a class="navbar-brand">
                <small style="color: white;">
                    <i class="fa fa-leaf"></i>
                    {{config('app.name')}}
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav d-flex flex-nowrap" style="">

                <li class="light-blue">
                    <span>
                        <span class="nav-user-photo fa fa-globe"></span>
                        <span>
                            <small class="text-capitalize text-white">
                                {{\Auth::user()->campus_id ? 'Campus Admin' : 'Admin'}}
                            </small>
						</span>
                    </span>
                </li>
                <li class="grenn dropdown-modal">
                    <a data-toggle="dropdown" class="dropdown-toggle text-white font-weight-bold text-capitalize" href="#" id="navbarDropdownMenuLink" style="background-color: {{$bg2}};">
                        {{ Config::get('languages')[Session::has('appLocale') ? Session::get('appLocale') : App::getLocale()] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != Session::get('appLocale'))
                                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a>
                        @endif
                    @endforeach
                    </div>
                </li>
                <li class="grenn dropdown-modal">
                    <a data-toggle="dropdown" class="dropdown-toggle text-white font-weight-bold text-capitalize" id="bg_primary_1"  style="background-color: {{$bg2}};">
                      {{\App\Models\Batch::find(\App\Helpers\Helpers::instance()->getCurrentAccademicYear())->name}}
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>


                    <ul class="dropdown-menu">
                       @foreach(\App\Models\Batch::all() as $batch)
                            <li>
                                <a href="{{ route('mode',$batch->id) }}">{{$batch->name}}</a>
                            </li>
                       @endforeach
                    </ul>
                </li>
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle" id="bg_primary_2"  style="background-color: {{$bg2}};">
                        <img class="nav-user-photo" src="{{asset('assets/images/avatars/user.jpg')}}"
                             alt="Jason's Photo"/>
                        <span>
						<small class="text-capitalize">{{__('text.word_welcome')}}</small>
                         {{\Auth::user()->name}}
						</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                        <li>
                            @if(\Auth::guard('student')->user() == null)
                                @if(\Auth::user()->isHod || \Auth::user()->isTeacher)
                                    <a href="{{route('user.home')}}" class="text-capitalize"><i
                                            class="ace-icon fa fa-user"></i>__('text.word_profile')</a>
                                @elseif(\Auth::user()->isAdmin)
                                    <a href="{{route('admin.home')}}" class="text-capitalize"><i
                                            class="ace-icon fa fa-user"></i>__('text.word_profile')</a>
                                @endif
                            @else
                                <a href="{{route('student.home')}}" class="text-capitalize"><i
                                        class="ace-icon fa fa-user"></i>__('text.word_profile')</a>
                            @endif
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
												document.getElementById('logout-form').submit();" class="text-capitalize">
                                <i class="ace-icon fa fa-power-off"></i>
                                {{__('text.word_logout')}}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>
<div class="main-container ace-save-state" id="main-container">

    <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
        <script type="text/javascript">
            try {
                ace.settings.loadState('sidebar')
            } catch (e) {
            }
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts" style="background-color: {{$bg3}};">
            <div>
                <h5>{{\App\Models\Batch::find(\App\Helpers\Helpers::instance()->getCurrentAccademicYear())->name}}</h5>
            </div>
        </div><!-- /.sidebar-shortcuts -->
        <ul class="nav nav-list">
            <li>
                <a
                    href="{{route('admin.home')}}">
                    <i style="color: {{$bg1}}" class="menu-icon fa fa-dashboard"></i>
                    <span class="menu-text text-capitalize">{{__('text.word_dashboard')}}</span>
                </a>
                <b class="arrow"></b>
            </li>
            
            @if (\Auth::user()->hasPermissionTo('basic_settings'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-cog"></i>
                    <span class="menu-text"> {{__('text.base_settings')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li>
                        <a href="{{route('admin.setayear')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.set_academic_year')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.admission.open')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.configure_admission')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.admission.programs.config')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.certificate_programs')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.admission.campus.degrees')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.campus_degrees')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.admission.degree.certificates')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.degree_certificates')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.programs.set_appliable')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.appliable_programs')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.programs.p2.index')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admission_letter')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            @endif
            
            @if (\Auth::user()->hasPermissionTo('manage_admissions'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-file"></i>
                    <span class="menu-text"> {{__('text.applicants_center')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    
                    <li>
                        <a href="{{route('admin.applications.print_form')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.word_applications')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.update')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.update_applicant')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.admit')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admit_student')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.admitted_students')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admitted_students')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.uncompleted')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.word_uncompleted')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.admission_letter')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admission_letters')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.change_program')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.change_program')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.students.index')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.reset_password')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                   
                </ul>
            </li>
            @endif
            
            @if (\Auth::user()->hasPermissionTo('manage_custom_applications'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-file"></i>
                    <span class="menu-text"> {{__('text.custom_applications')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    
                    <li>
                        <a href="{{route('admin.custom_applications.index')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.word_all')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.custom_applications.create')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admit_foreigners')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.custom_applications.switch')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.switch_program')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.custom_applications.import')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.word_import')}}
                        </a>

                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>
            @endif

            @if (\Auth::user()->hasPermissionTo('access_reports'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-asterisk"></i>
                    <span class="menu-text"> {{__('text.word_reports')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li>
                        <a href="#" class="dropdown-toggle text-capitalize">
                            <i  style="color: {{$bg1}}"class="menu-icon  fa fa-cog"></i>
                            <span class="menu-text"> {{__('text.application_totals')}}</span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            {{-- <li>
                                <a href="{{route('admin.applications.by_degree')}}" class="text-capitalize">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{__('text.by_degree_type')}}
                                </a>

                                <b class="arrow"></b>
                            </li> --}}
                            <li>
                                <a href="{{route('admin.applications.by_program')}}" class="text-capitalize">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{__('text.by_program')}}
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="submenu">
                    <li>
                        <a href="#" class="dropdown-toggle text-capitalize">
                            <i  style="color: {{$bg1}}"class="menu-icon  fa fa-cog"></i>
                            <span class="menu-text"> {{__('text.financial_reports')}}</span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li>
                                <a href="{{route('admin.applications.finance.general')}}" class="text-capitalize">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{__('text.general_reports')}}
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li>
                                <a href="{{route('admin.applications.finance.summary')}}" class="text-capitalize">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    @lang('text.summary_report')
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.bypass.report')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.bypass_report')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.applications.program_change.report')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.program_change_report')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            @endif

            @if (\Auth::user()->hasPermissionTo('manage_statistics'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-signal"></i>
                    <span class="menu-text"> {{__('text.statistics_zone')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li>
                        <a href="{{route('admin.stats.application')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.application_statistics')}}
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.stats.admission')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.admission_statistics')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{route('admin.stats.bypass')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.application_bypass')}}
                        </a>

                        <b class="arrow"></b>
                    </li>
                    
                </ul>
            </li>
            @endif

            @if (\Auth::user()->hasPermissionTo('access_superuser_reports'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-signal"></i>
                    <span class="menu-text"> {{__('text.superuser_reports')}}</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li>
                        <a href="{{route('admin.super.platform_charge.report')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{__('text.daily_platform_charge')}}
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            @endif
            
            @if (\Auth::user()->hasPermissionTo('manage_user'))
            <li>
                <a href="#" class="dropdown-toggle text-capitalize">
                    <i  style="color: {{$bg1}}"class="menu-icon  fa fa-users"></i>
                    <span class="menu-text">
						{{__('text.user_accounts')}}
						</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu">
                    @if(auth()->user()->campus_id == null)
                    <li>
                        <a href="{{route('admin.users.index')}}?type=admin" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{trans_choice('text.add_admin', 2)}}
                        </a>
                        <b class="arrow"></b>
                    </li>
                    @endif

                    <li>
                        <a href="{{route('admin.roles.index')}}" class="text-capitalize">
                            <i class="menu-icon fa fa-caret-right"></i>
                           {{trans_choice('text.role', 2)}}
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            @endif
            
            @if(auth()->user()->hasPermissionTo('bypass_application_fee'))
                <li>
                    <a href="{{route('admin.applications.bypass')}}" class="text-capitalize">
                        <i  style="color: {{$bg1}};" class="fa fa-dollar menu-icon"></i>
                        {{__('text.application_bypass')}}
                    </a>
                    <b class="arrow"></b>
                </li>
            @endif
            
            @if (auth()->user()->hasPermissionTo('bypass_platform_charges'))
                <li>
                    <a href="{{route('admin.platform.bypass')}}" class="text-capitalize">
                        <i  style="color: {{$bg1}};" class="fa fa-dollar menu-icon"></i>
                        {{__('text.platform_bypass')}}
                    </a>
                    <b class="arrow"></b>
                </li>
            @endif
            <li>
                <a href="{{route('admin.reset_password')}}" class="text-capitalize">
                    <i  style="color: {{$bg1}};" class="fa fa-refresh menu-icon   "></i>
                    {{__('text.reset_password')}}
                </a>
                <b class="arrow"></b>
            </li>

            <li>
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   href="{{route('logout')}}" class="text-capitalize">
                    <i style="color: {{$bg1}}" class="menu-icon fa fa-lock"></i>
                    <span class="menu-text">	{{__('text.word_logout')}}</span>
                </a>
                <b class="arrow"></b>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon f ace-save-state"></i>
        </div>
    </div>
    <div class="main-content">
        <div class="main-content-inner">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb text-capitalize">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">{{__('text.word_home')}}</a>
                    </li>
                    <li class="active">{{__('text.word_dashboard')}}</li>
                    <li class="active"> {{__('text.fullname')}} : <b style="color: #e30000">{{\Auth::user()->name}}</b></li>

                </ul><!-- /.breadcrumb -->
            </div>

            <div class="m-5">
                <div style="max-height: 65vh; overflow:auto">
                    @if(Session::has('success'))
                        <div class="alert alert-success fade in">
                            <strong>Success!</strong> {{Session::get('success')}}
                        </div>
                    @endif
    
                    @if(Session::has('error'))
                        <div class="alert alert-danger fade in">
                            <strong>Error!</strong> {{Session::get('error')}}
                        </div>
                    @endif
    
                    @if(Session::has('message'))
                        <div class="alert alert-primary fade in">
                            <strong>Message!</strong> {!! Session::get('message') !!}
                        </div>
                    @endif
                </div>


                <div class="mb-4 mx-3">
                    <h4 id="title" class="font-weight-bold text-capitalize">{!! $title ?? '' !!}</h4>
                </div>
                @if ((auth()->user()->password_reset != 1) && (now()->diffInDays(\Illuminate\Support\Carbon::createFromTimestamp(auth()->user()->created_at)) >= 14) && (url()->current() != route('admin.reset_password')))
                    <div class="py-5 h3 text-center text-danger mt-5 text-capitalize">{{__('text.password_reset_request')}}</div>
                    <div class="py-3 d-flex justify-content-center mt-2">
                        <a class="btn btn-lg col-sm-4 rounded btn-primary text-center" href="{{route('admin.reset_password')}}">{{__('text.word_proceed')}}</a>
                    </div>
                @else
                    @yield('section')
                @endif
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <div class="footer-inner">
        <div class="footer-content" style="background:#fff">
            <span class="bigger-120">
               &copy; {{__('text.copyright')}}
            </span>
            &nbsp; &nbsp;
            
        </div>
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div>
<script src="{{asset('assets/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
<script src="{{asset('assets/js/ace.min.js')}}"></script>
<script src="{{ asset('libs')}}/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('libs')}}/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>

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
                                    "{!! $title ?? '' !!}",
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
            // order: [
            //     [1, 'asc']
            // ],
        });

    });

    function delete_alert(event, data) {
        event.preventDefault();
        let yes = confirm('You are about to delete an item:'+data+'. This operation can not be reversed. Delete item?');
        if(yes){
            window.location = event.target.href;
        }
    }
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