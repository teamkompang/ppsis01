@extends('layouts.app_login')

@section('content')
<div class="col-md-6 col-lg-5">
                    @include('message')
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Register To PPSIS</h2>
						</div>
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="input-group custom">
                                <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ $invite->company }}" required autocomplete="company" disabled>
                                <input id="company" type="hidden" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ $invite->company }}" required autocomplete="company">
                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                            <div class="input-group custom">
								<input class="form-control form-control-lg  @error('username') is-invalid @enderror" name="username" id="username" type="text" placeholder="Username" required>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                            <div class="input-group custom">
								<input class="form-control form-control-lg  @error('fullname') is-invalid @enderror" name="fullname" id="fullname" type="text" placeholder="Fullname" required>
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
							</div>
							<div class="input-group custom">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $invite->email }}" required autocomplete="email" disabled>
                                <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $invite->email }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>
                            
                            <div class="input-group custom">
								<input class="form-control form-control-lg" name="email_confirmation" id="email-confirm" type="email" autocomplete="new-email" placeholder="Email Confirmation" required>
                            </div>
                            
                            <div class="input-group custom">
								<input class="form-control form-control-lg  @error('contact') is-invalid @enderror" name="contact" id="contact" type="tel" pattern="[0-9]{11}" placeholder="60327851515 or 0112345678901" required>
                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>

							<div class="input-group custom">
								<input  id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                                <small class="form-text text-muted">
                                    Your password must be minimum 8 characters long, contain letters, special characters and numbers, and must not contain spaces or emoji.
                                </small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                            <div class="input-group custom">
								<input  id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Password Confirmation">
                                                                
                            </div>
                            
                            <input id="role" type="hidden" class="form-control" name="role" value="{{ $invite->role }}" required autocomplete="role" >
                            <input id="status" type="hidden" class="form-control" name="status" value="{{ $invite->status }}" required autocomplete="status" >
                            <input id="status" type="hidden" class="form-control" name="access_expired" value="{{ $invite->access_expired }}" required autocomplete="access_expired" >
                            <input id="status" type="hidden" class="form-control" name="received_email" value="{{ $invite->received_email }}" required autocomplete="received_email" >
                            <input id="user_lastmaintain" type="hidden" class="form-control" name="user_lastmaintain" value="System" required autocomplete="user_lastmaintain" >

							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                                        -->
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('Register') }}
                                        </button>
										
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
@endsection
