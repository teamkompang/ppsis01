@extends('layouts.app')

@section('content')
@auth
<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4>Profile</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/home">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<h5 class="text-center h5 mb-0">{{ Auth::user()->fullname }}</h5>
							<p class="text-center text-muted font-14"></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-black">Contact Information</h5>
								<ul>
									<li>
										<span>Email Address:</span>
										{{ Auth::user()->email }}
									</li>
									<li>
										<span>Phone Number:</span>
										{{ Auth::user()->contact }}
									</li>
									<li>
										<span>Company:</span>
										{{ Auth::user()->company }}
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Profile Maintenance</a>
										</li>
									</ul>
									@include('message')
									<div class="tab-content">
										<!-- Profile Maintenance Tab start -->
										<div class="tab-pane fade height-100-p show active" id="setting" role="tabpanel">
											<div class="profile-setting">
												<form action="{{ route('profilemaintain.update' , Auth::user()->id) }}" method="POST" name="new_param">
													@csrf
													@method('patch') 
													<ul class="profile-edit-list row">
														<li class="weight-500 col-md-12">
															<h4 class="text-black h5 mb-20">Edit Your Personal Setting</h4>
															<div class="form-group">
																<label>Full Name</label>
																<input class="form-control form-control-lg" type="text" value="{{ Auth::user()->fullname }}" placeholder="Name" name="fullname">
															</div>
															<div class="form-group">
																<label>Email</label>
																<input class="form-control form-control-lg" type="email" value="{{ Auth::user()->email }}" placeholder="Email" name="email">
															</div>
															<div class="form-group">
																<label>Phone Number</label>
																<input class="form-control form-control-lg" type="text" value="{{ Auth::user()->contact }}" placeholder="Phone Number" name="contact">
															</div>
                                                            <div class="form-group">
																<label>Password</label>
																<input  id="password" type="password" class="form-control form-control-lg" name="password"  placeholder="Password">
																<small class="form-text text-muted">
																	Your password must be minimum 8 characters long, contain letters, special characters and numbers, and must not contain spaces or emoji.
																</small>
                                                            </div>
                                                            <div class="form-group">
																<label>Password confirmation</label>
																<input  id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation"  autocomplete="new-password" placeholder="Password Confirmation">
															</div>
															<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
															<input class="form-control form-control-sm form-control-line" type="hidden" name="company" value="{{ Auth::user()->company }}">
															<input class="form-control form-control-sm form-control-line" type="hidden" name="username" value="{{ Auth::user()->username }}">
															<div class="form-group mb-0">
																@can('all_profilemaintain-edit')
																<input type="submit" class="btn btn-primary" value="Update Information">
																@endcan
															</div>
														</li>
													</ul>
												</form>
											</div>
										</div>
										<!-- Setting Tab End -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
    </div>
@endauth
@endsection