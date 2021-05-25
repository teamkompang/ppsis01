@extends('layouts.app')

@section('content')
<style>
    .box{
        color: black;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    .red{ background: #ff0000; }
    .green{ background: #228B22; }
    .blue{ background: #0000ff; }
    .hitam{ background: black; }
    label{ margin-right: BLACK; }
</style>

    <div class="main-container">    
        <!-- <div>
            <label><input type="checkbox" name="colorCheckbox" value="red"> red</label>
            <label><input type="checkbox" name="colorCheckbox" value="green"> green</label>
            <label><input type="checkbox" name="colorCheckbox" value="blue"> blue</label>
        </div> -->

        <div class="custom-control custom-checkbox mb-5">
            
        </div>

            <label><input type="checkbox"   name="colorCheckbox" value="hitam" id="customCheck1">Hitam</label>
            <label><input type="checkbox"   name="colorCheckbox" value="red" id="customCheck1"> red</label>
            <label><input type="checkbox"   value="attachment" id="customCheck1"> attachment</label>
            <label class="custom-control-label" for="customCheck1">Include attachment</label>

        <div class="red box">You have selected <strong>red checkbox</strong> so i am here</div>
        <div class="green box">You have selected <strong>green checkbox</strong> so i am here</div>
        <div class="blue box">You have selected <strong>blue checkbox</strong> so i am here</div>
        <div class="hitam box">You have selected <strong>blue checkbox</strong> so i am here</div>
        <div class="attachment box">
                <div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4">Dropzone</h4>
						</div>
					</div>
					<form class="dropzone" action="#" id="my-awesome-dropzone">
						<div class="fallback">
							<input type="file" name="file" />
						</div>
					</form>
                </div>
        </div>
    </div>
    

    

@endsection
