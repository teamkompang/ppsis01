<!-- Vlo modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update Case</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('panelvlo.store') }}" method="POST" name="vlos">
                    @csrf
                    <div class="modal-body">
                        <label class="col-sm-12 col-md-12 col-form-label">Solicitor Name</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel" disabled>
                            <input class="form-control form-control-sm form-control-line" type="text" value="{{ Auth::user()->company }}" name="panel_update" disabled>
                            <input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel_update" >
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">User Name</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control form-control-sm form-control-line" type="text" value="{{ Auth::user()->fullname }}"  disabled>
                            <input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->fullname }}" name="pic">
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Issue Date</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control date-picker" placeholder="Select Date" type="text" name="issue_date">
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Detail</label>
                        <div class="col-sm-16 col-md-16">
                            <textarea class="form-control" name="details"></textarea>
                        </div>
                       
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel" >
						<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $vlos->ID }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="status_comment" value="Active">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="status_case" value="Active">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="update_date" value="{{ $current_time }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

