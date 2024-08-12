@extends('layouts.master')
@section('content')
<div class="box">
    <div class="box-header with-border" style="justify-content: space-between; display: flex;">
        <h3 class="box-title">Daftar Driver Ambulans</h3>
        <button type="button" class="btn btn-primary" onclick="add_ajax()">
            <i class="ti-plus"></i>
            Tambah
        </button>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Nomor Whatsapp</th>
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
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->no_hp }}</td>
                        <td>
                            <a href="javascript:void(0)" onclick="edit('{{ $row->id }}')" class="text-info me-10"><i class="ti-marker-alt"></i></a>
                            <a href="javascript:void(0)" onclick="hapus('{{ $row->id }}')" class="text-danger"><i class="ti-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal  -->
<div class="modal fade text-left" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Form Data Driver</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form class="form" action="" method="POST" id="formAdd" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h5>Nama Driver <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="name" class="form-control" required data-validation-required-message="Kolom ini wajib Di Isi" placeholder="Nama Lengkap">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h5>Username <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="username" class="form-control" required data-validation-required-message="Kolom ini wajib Di Isi" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="form-group" id="password">
                                            <h5>Password <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="password" name="password" class="form-control" required data-validation-required-message="Kolom ini wajib Di Isi" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h5>No Whatsapp <span class="text-danger">*</span></h5>
                                            <div class="input-group">
                                                <input type="number" name="no_hp" class="form-control" required data-validation-required-message="This field is required" placeholder="No Whatsapp">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" onclick="save()" id="btnSaveAjax" class="btn btn-success text-start">
                    Simpan
                </a>
                <button type="button" class="btn btn-danger text-start" data-bs-dismiss="modal">Batal</button>
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

    function add_ajax() {
        method = 'add';
        resetForm();
        $('#myModalLabel1').html("Tambah Driver");
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#m_modal').modal('show');
        $('#password').show();
    }

    function save() {
        let url;

        if (method === 'add') {
            url = "{{ route('driver.store') }}";
        } else {
            url = "{{ route('driver.update') }}";
        }

        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);

        $.ajax({
            url: url,
            type: "POST",
            data: formDataWithToken,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    $('#m_modal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil..',
                        text: 'Data Anda berhasil disimpan',
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

    function edit(id) {
        method = 'edit';
        resetForm();

        $('#myModalLabel1').html("Edit Driver");

        $.ajax({
            url: "{{ url('driver/edit') }}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.data) {
                    $('#formAdd')[0].reset();
                    $('[name="id"]').val(data.data.id);
                    $('[name="name"]').val(data.data.name);
                    $('[name="username"]').val(data.data.username);
                    $('[name="no_hp"]').val(data.data.no_hp);
                    $('#password').hide();
                    $('#m_modal').modal('show');
                } else {
                    Swal.fire("Oops", "Gagal mengambil data!", "error");
                }
                mApp.unblockPage();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                mApp.unblockPage();
                Swal.fire("Error", "Gagal mengambil data dari server!", "error");
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda yakin ingin hapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "<span><i class='flaticon-interface-1'></i><span>Ya, Hapus!</span></span>",
            confirmButtonClass: "btn btn-danger m-btn m-btn--pill m-btn--icon",
            cancelButtonText: "<span><i class='flaticon-close'></i><span>Batal Hapus</span></span>",
            cancelButtonClass: "btn btn-metal m-btn m-btn--pill m-btn--icon",
            customClass: {
                confirmButton: 'btn btn-danger m-btn m-btn--pill m-btn--icon',
                cancelButton: 'btn btn-metal m-btn m-btn--pill m-btn--icon'
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('driver') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status === true) {
                            Swal.fire({
                                title: "Berhasil..",
                                text: "Data Anda berhasil dihapus",
                                icon: "success"
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Oops", "Data gagal dihapus!", "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire("Oops", "Data gagal dihapus!", "error");
                    }
                });
            }
        });
    }
</script>
@endsection