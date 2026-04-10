    
    <!-- start action log modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-modal" id="action-log-universal-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form id="ActionLogForm">    
            <div class="modal-dialog sidebar-xl action_slide_modal" style="width: 30%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title slide_form_title" id="action-log-title">User Log Information</h5>
                        <div class="slide_form_title info_modal_title_lbl" style="text-align: center;padding-right:30px;" id="action-log-status-lbl"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor" style="overflow-y:auto;height:100vh;">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <ul id="universal-action-log-canvas" class="timeline mb-0 mt-1"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebutton-action-log" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end action log modal-->


    <script type="text/javascript">
        var warning_title = "Warning!";
        var warning_icon = "warning";
        var delete_record_text1 = "Are you sure you want to delete this record? This action cannot be reversed.";
        var delete_record_text2 = "Are you sure you want to delete this record?";

        var password_reset_confirmation = "Are you sure you want to reset the password?";
        var undo_void_confirmation = "Are you sure you want to perform a void reversal for this record?";

        var confirmation_title = "Confirmation";
        var confirmation_icon = "question";
    </script>