<!-- Financing modal -->
<div class="col-md-4 col-sm-16 mb-30">
    <div class="modal fade bs-example-modal-lg" id="cases" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="test">Cases</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="pd-20 card-box">
                    <div class="tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-blue" data-toggle="tab" href="#home" role="tab" aria-selected="true">List of Cases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-blue" data-toggle="tab" href="#profile" role="tab" aria-selected="false">List of Agreement</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <div class="pd-20">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel">
                                <div class="pd-20">
                                    <form method="POST" action="{{route('punbfinancing.store')}}" onsubmit="return false;">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <select name="from" id="multiselect" class="form-control" size="8" multiple="multiple">
                                                <option value="1">C++</option>
                                                <option value="2">C#</option>
                                                <option value="3">Haskell</option>
                                                <option value="4">Java</option>
                                                <option value="5">JavaScript</option>
                                                <option value="6">Lisp</option>
                                                <option value="7">Lua</option>
                                                <option value="8">MATLAB</option>
                                                <option value="9">NewLISP</option>
                                                <option value="10">PHP</option>
                                                <option value="11">Perl</option>
                                                <option value="12">SQL</option>
                                                <option value="13">Unix shell</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                            </div>
                                            <div class="col-xs-5">
                                                <select name="to" id="multiselect_to" class="form-control" size="8" multiple="multiple">
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#cloneBtn').click(function() {
    var $options = $("#myselect > option").clone();
    $('#second').append($options);
});
</script>


