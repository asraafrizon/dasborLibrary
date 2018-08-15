@extends('layouts.based')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                        <div>
        <form method="post" action="{{route('koleksi.import')}}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <h3>Export data koleksi</h3>

                <div class="form-group">
                    <label for="export" class="col-md-3 control-label">Export</label>
                    <div class="col-md-8">
                        <a href="{{route('koleksi.export')}}" class="btn btn-success">Export</a>
                    </div>
                </div>

                <div class="form-group">
                    <label for="import" class="col-md-3 control-label">Import</label>
                    <div class="col-md-8">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </form>

        <form method="post" action="{{route('inventori.import')}}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <h3>Export data inventori</h3>
                <div class="form-group">
                    <label for="export" class="col-md-3 control-label">Export</label>
                    <div class="col-md-8">
                        <a href="{{route('inventori.export')}}" class="btn btn-success">Export</a>
                    </div>
                </div>

                <div class="form-group">
                    <label for="import" class="col-md-3 control-label">Import</label>
                    <div class="col-md-8">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>


            </div>
        </form>

        <form method="post" action="{{route('layanan.import')}}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <h3>Export data layanan</h3>
                <div class="form-group">
                    <label for="export" class="col-md-3 control-label">Export</label>
                    <div class="col-md-8">
                        <a href="{{route('layanan.export')}}" class="btn btn-success">Export</a>
                    </div>
                </div>

                <div class="form-group">
                    <label for="import" class="col-md-3 control-label">Import</label>
                    <div class="col-md-8">
                        <input type="file" name="file" class="form-control" required>
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
        </div>
    </div>
</div>
@endsection
