@extends('layouts.app_login')

@section('content')
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-world">Login To PPSIS</h2>
						</div>
						@include('message')
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
							<div class="input-group custom">
								<input class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email" id="email" type="email" placeholder="Email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input  id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="forgot-password"><a href="{{ route('password.request') }}">Forgot Password</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                                        -->
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('Login') }}
                                        </button>
										
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
@endsection
