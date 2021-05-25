@extends('layouts.app')

@section('content')
@auth
<div class="main-container">    
		<div class="pd-ltr-20">
            <div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="{{ asset('img/logo1.png') }}" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome <div class="weight-600 font-30 text-world">{{ Auth::user()->fullname }}</div>
						</h4>
						<p class="font-18 max-width-600">{{ date("d-M-Y") }}</p>
						<p class="font-18 max-width-600">PUNB Panel Solicitor Information System (PPSIS)</p>
					</div>

				</div>
            </div>
            	
		</div>
	</div>
@endauth	
@endsection
