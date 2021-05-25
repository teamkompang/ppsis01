<!-- Reinstates modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="attachment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update Case</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="col-sm-12 col-md-12 col-form-label">File Name</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control" type="text" name="name">
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Description</label>
                        <div class="col-sm-16 col-md-16">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">File</label>
                        <div class="col-sm-16 col-md-16">
                            <input class="form-control" type="file" name="userFile">
                        </div>                       
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="user_created" value="{{ Auth::user()->fullname }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" name="pic" value="{{ Auth::user()->fullname }}">
                        <input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel_update" >
						<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $reinstates->ID }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="sis_id" value="{{ $reinstates->sis_id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

