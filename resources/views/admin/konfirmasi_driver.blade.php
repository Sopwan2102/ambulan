@extends('layouts.master')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Konfirmasi Driver Ambulans</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Driver</th>
                        <th>Nomor Plat Ambulans</th>
                        <th>Biaya/Tarif</th>
                        <th>Ambulans Milik</th>
                        <th>Nomor Whatsapp</th>
                        <th>Surat Operasional</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->no_plat }}</td>
                        <td>{{ $row->biaya }}</td>
                        <td>{{ $row->milik }}</td>
                        <td>{{ $row->no_hp }}</td>
                        <td><img src="{{ Storage::url($row->surat_izin) }}" alt="product" width="30" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewImage">
                            <div class="modal fade" id="viewImage" tabindex="-1" aria-labelledby="viewImageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewImageModalLabel">Foto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ Storage::url($row->surat_izin) }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div></td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onclick="add_ajax('{{ $row->ambulan_id }}')">
                                Konfirmasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">Form Data Ambulans</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form class="form" action="" method="POST" id="formAdd" enctype="multipart/form-data">
                <input type="hidden" name="ambulan_id" value="">
                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
            </form>
		  </div>
		  <div class="modal-footer modal-footer-uniform">
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
			<a href="#" onclick="save()" id="btnSaveAjax" class="btn btn-success text-start">
                    Simpan
            </a>
		  </div>
		</div>
	  </div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function resetForm() {
        $('#formAdd')[0].reset();
    }

    function add_ajax(id) {
        method = 'add';
        ambulan_id = id;
        resetForm();
        $('#myModalLabel1').html("Konfirmasi Driver");
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#m_modal').modal('show');
    }

    function save() {
    
        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken) + '&ambulan_id=' + encodeURIComponent(ambulan_id);

        $.ajax({
            url: "{{ route('driver.approval') }}",
            type: "POST",
            data: formDataWithToken,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    $('#m_modal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil..',
                        text: 'Approval Berhasil',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        text: data.message,
                        icon: 'warning'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: 'Oops',
                    text: 'Data gagal disimpan!',
                    icon: 'error'
                });
            }
        });

    }

</script>
@endsection