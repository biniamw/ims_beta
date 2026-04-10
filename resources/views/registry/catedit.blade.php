<form action="{{url('catupdate/'.$cat->id)}}" method="post">
    <div class="modal-body">
        @csrf
        @method('PUT')
        <h5 class="text-center">Are you sure you want to update {{ $cat->Name }} ?</h5>

        <div class="form-group">
            <label for="categoriesName" class="col-sm-4 control-label">Categories Name: </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="categoriesName" value="{{$cat->Name}}" placeholder="Categories Name" name="categoriesName" autocomplete="off">
              </div>
        </div>

        <div class="form-group">
            <label for="categoriesStatus" class="col-sm-4 control-label">Status: </label>
            <label class="col-sm-1 control-label">: </label>
                <div class="col-sm-7">
                  <select class="form-control" id="status" name="categoriesStatus">
                      <option value="">{{$cat->ActiveStatus}}</option>
                      <option value="active">Active</option>
                      <option value="not Active">Not Active</option>
                  </select>
                </div>
        </div> <!-- /form-group-->	     


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn success">Yes, Update</button>
    </div>
</form>
