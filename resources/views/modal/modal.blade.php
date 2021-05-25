<!-- Create New Group Parameter modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="crete-group-param" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create New Group Parameter1</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('paramsetting.store') }}" method="POST" name="group_param">
                    @csrf
                    <div class="modal-body">
                        <label class="col-sm-10 col-md-12 col-form-label">Group Name</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="category_code">
                        </div>
                        <label class="col-sm-10 col-md-12 col-form-label">Description</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Create New Parameter modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="crete-new-parameter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create New Parameter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/paramsetting/store_param" method="POST" name="new_param">
                    @csrf
                    <div class="modal-body">
                        <label class="col-sm-10 col-md-12 col-form-label">Parameter Value</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="param_value">
                        </div>
                        <label class="col-sm-10 col-md-12 col-form-label">Value Detail</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="value_details">
                        </div>
                        <label class="col-sm-10 col-md-12 col-form-label">Description</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="description">
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Parameter Group</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="group">
                                <option>Choose...</option>
                                    @foreach ($groupparam as $param)
                                        <option value="{{ $param->category_code }}">{{ $param->category_code }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




