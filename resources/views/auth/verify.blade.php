@extends('layouts.app_login')

@section('content')
<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Please verify your account</h2>
						</div>
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                            <a class="btn btn-primary btn-lg btn-block" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
													  Back to login
													  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
															@csrf
														</form>
													</a>
                        </div>
					</div>
				</div>

@endsection
