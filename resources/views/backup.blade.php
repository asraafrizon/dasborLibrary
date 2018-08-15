@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>Data koleksi
                        <div class="pull-right">
                            
                            <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Contact</a>
                            
                        </div>
                    </div>


                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table id="koleksi-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Jurnal</th>
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('form.form-koleksi')
</div>
@endsection

<script type="text/javascript">
    var table = $('#koleksi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.koleksi') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'jurnal', name: 'jurnal'},
            {data: 'tahun', name: 'tahun'},
            {data: 'jumlah', name: 'jumlah'},
            {data: 'action', name: 'action', orderable: false, searchable:false}
        ]
    });


    function addForm() {
        save_method = "add";
        $('input[name=_method').val('POST');
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Add Koleksi');

    }


</script>