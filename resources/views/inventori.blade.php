@extends('layouts.based')

@section('content')
<div class="container">

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Data Inventori
            <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Inventori</a>
            <a onclick="addExim()" class="btn btn-default pull-right" style="margin-top: -8px;">Export/Import Data</a>
          </h4>
        </div>
        <div class="panel-body">
          <table id="inventori-table" class="table table-striped">
            <thead>
              <tr>
                <th width="30">No</th>
                <th>Fakultas</th>
                <th>Tahun</th>
                <th>Data Judul</th>
                <th>Data Eksemplar</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @include('form.form-inventori')

</div> <!-- /container -->
@endsection

@push('scripts')

<script type="text/javascript">
  var table = $('#inventori-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('api.inventori') }}",
    columns: [
    {data: 'id', name: 'id'},
    {data: 'fakultas', name: 'fakultas'},
    {data: 'tahun', name: 'tahun'},
    {data: 'data_judul', name: 'data_judul'},
    {data: 'data_eksemplar', name: 'data_eksemplar'},
    {data: 'action', name: 'action', orderable: false, searchable:false}
    ]
  });


  function addForm() {
    save_method = "add";
    $('input[name=_method]').val('POST');
    $('#modal-form').modal('show');
    $('#modal-form form')[0].reset();
    $('.modal-title').text('Add Inventori');
  }

  function editForm(id) {
    save_method = 'edit';
    $('input[name=_method]').val('PATCH');
    $('#modal-form form')[0].reset();

    $.ajax({
      url: "{{ url('inventori') }}" + '/' + id + "/edit",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#modal-form').modal('show');
        $('.modal-title').text('Edit Inventori');

        $('#id').val(data.id);
        $('#fakultas').val(data.fakultas);
        $('#tahun').val(data.tahun);
        $('#data_judul').val(data.data_judul);
        $('#data_eksemplar').val(data.data_eksemplar);

      },
      error : function() {
        alert("Nothing Data");
      }
    });
  }


  function deleteData(id)
  {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#d33',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then(function() {
      $.ajax({
        url: "{{ url('inventori') }}" + '/' +id,
        type: "POST",
        data: {'_method' : 'DELETE', '_token' : csrf_token},
        success: function(data) {
          table.ajax.reload();
          swal({
            title: 'Success!',
            text: data.message,
            type: 'success',
            timer: '1500'
          })
        },
        error: function() {
          swal({
            title: 'Oops...',
            text: data.message,
            type: 'error',
            timer: '1500'
          })
        }
      });
    });
  }

  $(function() {
    $('#modal-form form').validator().on('submit', function (e) {
      if(!e.isDefaultPrevented()) {
        var id = $('#id').val();
        if(save_method == 'add') url = "{{url('inventori') }}";
        else url = "{{ url('inventori') . '/'}}" + id;

        $.ajax({
          url: url,
          type: "POST",
          data: $('#modal-form form').serialize(),
          data: new FormData($("#modal-form form")[0]),
          contentType: false,
          processData: false,
          success: function(data) {
            $('#modal-form').modal('hide');
            table.ajax.reload();
            swal({
              title: 'Success!',
              text: data.message,
              type: 'success',
              timer: '1500'
            })
          },
          error : function(data) {
            swal({
              title: 'Opps...',
              text: data.message,
              type: 'error',
              timer: '1500'
            })
          }
        });
        return false;
      }
    });
  });

  function addExim() { 
    $('#modal-exim').modal('show');
    $('#modal-exim form')[0].reset();
  }


</script>

@endpush