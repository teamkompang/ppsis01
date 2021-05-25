	<!-- Show user modal -->
    <!-- <div class="modal fade" id="crud-modal-show" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userCrudModal-show"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-2 col-sm-2 col-md-2"></div>
                            <div class="col-xs-10 col-sm-10 col-md-10 ">
                                <table class="table-responsive ">
                                    <tr height="50px">
                                        <td><strong>CID</strong></td>
                                        <td>:</td>
                                        <td id="cid"></td>
                                    </tr>
                                    <tr height="50px">
                                        <td><strong>Email</strong></td>
                                        <td>:</td>
                                        <td id="pic"></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


     <div class="modal fade bs-example-modal-lg" id="crud-modal-show" aria-hidden="true" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userCrudModal-show"></h4>
                </div>
                <div class="modal-body">

							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Case Tracking Number</label>
									<div class="col-sm-12 col-md-10">
                                        <label class="col-sm-12 col-md-12 col-form-label">SIS{{ sprintf("%010d",$restructures->sis_id) }}</label>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">Date</label>
									<div class="col-sm-12 col-md-10">
                                        <label class="col-sm-12 col-md-12 col-form-label" id="issue_date"></label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
                                    <label class="col-sm-12 col-md-12 col-form-label">From</label>
									<div class="col-sm-12 col-md-10">
                                        <label class="col-sm-12 col-md-12 col-form-label" id="pic"></label>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">Panel Solicitors</label>
									<div class="col-sm-12 col-md-10">
                                        <label class="col-sm-12 col-md-12 col-form-label" id="panel_update"></label>
									</div>
								</div>

							</div>
                            <div class="dropdown-divider"></div>

                            <div class="row">
                                <label class="col-sm-12 col-md-12 col-form-label" id="details"></label>
							</div>
	

                </div>
            </div>
        </div>
    </div>

    