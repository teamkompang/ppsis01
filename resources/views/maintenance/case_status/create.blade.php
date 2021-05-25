@extends('layouts.app')

@section('content')
@auth
	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4></h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('casestatus.index') }}">Search</a></li>
                                    <li class="breadcrumb-item">Case Status</li>
                                    <li class="breadcrumb-item active" aria-current="page">Create New Status</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
                @include('message')
				<div class="pd-20 card-box mb-30" align="center">
                    <div class="pull-left">
                        <h4 class="text-black h4">Create New Case</h4>
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <select class="custom-select col-12" id="features" name="Features[]"  size="9" multiple="multiple">
                        @if ($listagreeno  != "")
                            @foreach(explode(',', $listagreeno) as $info) 
                                <option value="{{$info}}">{{$info}}</option>
                            @endforeach
                        @endif   
                       
                        </select>
                    </div>
                    <br/>
                        <button type="button" value="" class="btn btn-xs btn-primary" id="add"><i class="dw dw-down-chevron-1"></i></button>
                        <button type="button" value="" class="btn btn-xs btn-danger" id="remove"><i class="dw dw-up-chevron-1"></i></button> 
                    <br/><br/>
                    <form method="POST" action="{{route('casestatus.store')}}" >
                        @csrf
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="case_no[]" size="9" id="selected_features" multiple="multiple" required>    
                            </select>
                        </div><br/>
                        
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_created" value="{{ Auth::user()->fullname }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $world[0]->ID }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="product" value="{{ $world[0]->PRDABBR }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="status" value="1">
                        <div class="">
                            <button type="submit" class="btn btn-primary">Create New Case</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
    </div>
    <script type="text/javascript">
$(document).ready(function(){
   $('#add').click(function() {  
    return !$('#features option:selected')
.remove().appendTo('#selected_features');  
   });  
   $('#remove').click(function() {  
    return !$('#selected_features option:selected')
.remove().appendTo('#features');  
   });  
    
function selectall()  {  
$('#selected_features').find('option').each(function() {  
   $(this).attr('selected', 'selected');  
  });  
}  
});
</script>
    @endauth
@endsection