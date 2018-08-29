<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-layanan" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{csrf_field()}} {{method_field('POST')}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="aktivitas" class="col-md-3 control-label">Aktivitas</label>
                        <div class="col-md-6">
                            <input type="text" id="aktivitas" name="aktivitas" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tahun" class="col-md-3 control-label">Tahun</label>
                        <div class="col-md-6">
                            <input type="number" id="tahun" name="tahun" min="2014" max="2099" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="data_layanan" class="col-md-3 control-label">Data Layanan</label>
                        <div class="col-md-6">
                            <input type="number" id="data_layanan" name="data_layanan" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-save">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>



<div class="modal" id="modal-exim" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-layanan" action=" {{ route('layanan.import') }} " method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title">Export/Import Data Layanan</h3>
                </div>

                <div class="modal-body">


                  <div class="form-group">
                    <label for="export" class="col-md-3 control-label">Export</label>
                    <div class="col-md-6">
                        <a href=" {{ route('layanan.export') }} " class="btn btn-success">Export</a>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file" class="col-md-3 control-label">Import</label>
                    <div class="col-md-6">
                        <input type="file" id="file" name="file" class="form-control"  required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>



                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>