<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Change password</h4>
        </div>
        <div class="modal-body">
            <label>Old password: </label><input type="text" class="form-control" id="oldPassword" name="oldPassword">
            <label>New Password: </label><input type="text" class="form-control" id="newPassword1" name="newPassword1">
            <label>Confirm new Password: </label><input type="text" class="form-control" id="newPassword2" name="newPassword2">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitPassword()" data-dismiss="modal">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->