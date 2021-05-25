@if (count($errors) > 0)
    <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>
@endif