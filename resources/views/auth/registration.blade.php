<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>{{config('app.name')}}</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/fonts.googleapis.com.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
		<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script> -->

		@php
			$bg1 = \App\Http\Controllers\HomeController::getColor('background_color_1');
			$bg2 = \App\Http\Controllers\HomeController::getColor('background_color_2');
			$bg3 = \App\Http\Controllers\HomeController::getColor('background_color_3');
			$bg_path = \App\Helpers\Helpers::instance()->getBackground();
		@endphp

		<style>
			body{
				background-image: url("{{asset('assets/images/background1.png')}}");
				background-position: center;
				background-size: cover;
				background-repeat: no-repeat;
				background-attachment: fixed;

			}

				/* Rectangle 23 */
			#login-frame{
				position: relative;
				width: 350px;
				height: 450px;
				min-height: fit-content;
				margin-inline: auto;
				border-radius: 24px;
			}
				/* Rectangle 23 */
			#login-frame .rect1{
				position: absolute;
				width: 100%;
				height: 100%;
				min-height: fit-content;
				background: @bg2;
				border-radius: 24px;
				top: -9px;
			}

				/* Rectangle 22 */
			#login-frame .rect2{
				position: absolute;
				width: 100%;
				height: 100%;
				min-height: fit-content;
				margin-inline: auto;
				background: {{ $bg1 }};
				box-shadow: 0px 0px 34px rgba(0, 0, 0, 0.25);
				border-radius: 24px;
				left: 9px;
				z-index: 20;
			}
				/* input bg */
			#login-frame .main-rect{
				position: absolute;
				width: 100%;
				height: 100%;
				min-height: fit-content !important;
				background: white;
				border-radius: 24px;
				z-index: 30;
			}

			#login-frame .main-rect div{
				background: white;
			}

		    a{
		        text-decoration:none;
		        font-weight:bold;
		        font-size:16px;
		        color:#fff;
		    }
			#login-box{
				border-radius: 24px;
				margin-block: 3rem;
			}

			.blink{
				animation: blinker 1s linear infinite;
			}
			@keyframes blinker {
				50% {
					opacity: 0;
				}
			}
		</style>
	</head>

	<body class="login-layout" id="frame">
		<div class="container-fluid py-2 h3 text-uppercase font-semibild h4 blink" style="font-weight: 700; color: #f00;"><i>{{ $announcement??'' }}</i></div>
		<div class="main-container px-5" style="padding-inline: 2rem;">
			<div class="w-100 text-center" style="padding: 0.2rem; margin-block: 0.1rem;">
				<h4> <span style="color: {{ $bg3 }}; text-shadow: -1px -1px 0 #1a55c4, 1px -1px 0 #1a55c4, -1px 1px 0 #1a55c4, 1px 1px 0 #1a55c4; font-weight: bolder; font-size: large; transform: skew(12deg, 17deg) !important;">{{__('text.stlo_portal')}}</span></h4>
			</div>
			
			<div style="display: flex; justify-content: center; padding-bottom: 3rem; text-align: center; text-transform: capitalize; color: black !important;">
				<span style="text-shadow: -1px 0px 0 #3369ce, 1px 0px 0 #1a55c4;">{{__('text.powered_by')}} <b style="font-size:large; font-weight:bold;"> {{__('text.nishang_system')}} </b></span>
			</div>
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
			<div class="main-content">
				<div class="w-100">
					<div class="login-container" id="login-frame">

						<div class="rect1"></div>

						<div class="rect2"></div>
						<div class="position-relative main-rect ">

							<div id="login-box" class="login-box no-border">
								<div class="widget-body" style="padding-inline: 3rem !important;">
									<div class="widget-main">
										<h4 class="bigger text-capitalize" style="color: black !important; font-size: xlarge;">
											<b>{{__('text.word_register')}}</b>
										</h4>
										<span style="font-size: small; margin-bottom: 1rem; color: black !important;">{{__('text.begin_account_creation')}}</span>

										<form method="POST" action="{{ route('check_matricule') }}" style="padding-block: 3rem !important;">
											@csrf
											<fieldset>
												<label class="block clearfix">
													<span class="text-capitalize">{{__('text.word_matricule')}}</span>
													<span class="block input-icon input-icon-right">
														<input type="text" required name="reg_no" class="form-control"  style="border-radius: 0.5rem !important; background-color: white !important; color: black"/>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right" style="text-transform: capitalize;">
														<input type="checkbox" name="is_parent">  {{__('text.create_parent')}}
													</span>
												</label>

												<div class="clearfix">
													<button type="submit" class="form-control btn-black btn-sm"  style="border-radius: 2rem; background-color: {{ $bg2 }}; border: 1px solid {{ $bg1 }}; color: white; text-transform: capitalize; margin-block: 2rem;">
														{{__('text.next_step')}}
													</button>
												</div>
											</fieldset>
										</form>
									</div><!-- /.widget-main -->

									<div  class="toolbar clearfix" style="border: 0px; padding-inline: 1rem;">
										<a href="{{route('login')}}" data-target="#login-box" class="form-control btn-black btn-sm text-center"  style="border-radius: 2rem; background-color: {{ $bg2 }}; border: 1px solid {{ $bg1 }}; color: white; text-transform: capitalize; font-weight: normal !important;">
											<i class="ace-icon fa fa-arrow-left"></i>
											{{__('text.back_to_login')}}
										</a>
									</div>
								</div><!-- /.widget-body -->
							</div><!-- /.forgot-box -->

						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.main-content -->

		</div><!-- /.main-container -->
		@if($help_contacts != null)
			<div class="alert alert-light text-center text-uppercase margin-top-5 h4"><b><i>{{ 'IN NEED OF HELP, CONTACT: '.$help_contacts }}</i></b></div>
		@endif
	</body>
</html>
