<!-- Create New User modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="crete-new-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{url('send-email')}}">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <label class="col-sm-10 col-md-12 col-form-label">Email</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" name="email" >
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Company</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="company">
                                <option selected="">Choose...</option>
                                @foreach ($panelset as $panel)
                                    <option value="{{ $panel->ICode }}">{{ $panel->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Role</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="roles">
                                <option selected="">Choose...</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="status"> 
                                <option selected="">Choose...</option>
                                @foreach ($status as $stat)
                                    <option value="{{ $stat->param_value }}">{{ $stat->value_details }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Received Email</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="received_email" >
                                    @foreach ($emailstat as $stat)
                                        <option value="{{ $stat->param_value }}">{{ $stat->value_details }}</option>
                                        
                                    @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Access Expired</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control date-picker" placeholder="Select Date" type="text" name="access_expired">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create New Public modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="crete-public-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create Public User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form>
                    <div class="modal-body">
                        <label class="col-sm-10 col-md-12 col-form-label">Email</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" >
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Company</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="company" >
                                    @foreach ($panelset as $panel)
                                        <option value="{{ $panel->ICode }}">{{ $panel->Name }}</option>
                                        
                                    @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Role</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="status" >
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat->param_value }}">{{ $stat->value_details }}</option>
                                        
                                    @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="custom-select col-12" name="status" >
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat->param_value }}">{{ $stat->value_details }}</option>
                                        
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>