@extends('layouts.master')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD49orLyT6fzUuLRQLcKTB4aSEDNyQFWs&callback=initMap&libraries=places" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            @foreach($data as $row)
                @php
                    // Pemisahan lokasi menjadi latitude dan longitude
                    list($latitude, $longitude) = explode(',', $row->lokasi);
                @endphp
                getAddress('{{ trim($latitude) }}', '{{ trim($longitude) }}', '{{ $row->ambulan_id }}');
            @endforeach
        });

        let map;
        let marker;
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($data as $row)
                @php
                    list($latitude, $longitude) = explode(',', $row->lokasi);
                @endphp
                getAddress('{{ trim($latitude) }}', '{{ trim($longitude) }}', '{{ $row->ambulan_id }}');
            @endforeach
        });

        function initMap() {
            const pekanbaruCenter = { lat: 0.5071, lng: 101.4478 }; // Pusat koordinat Pekanbaru

            map = new google.maps.Map(document.getElementById("map"), {
            center: pekanbaruCenter,
            zoom: 12,
            });

            const pekanbaruBounds = {
            north: 0.6059,
            south: 0.4507,
            east: 101.5371,
            west: 101.4087,
            };

            map.fitBounds(pekanbaruBounds);

            marker = new google.maps.Marker({
            position: pekanbaruCenter,
            map: map,
            draggable: true,
            });

            google.maps.event.addListener(marker, 'dragend', function() {
            const position = marker.getPosition();
            document.getElementById("location").value = position.lat() + ', ' + position.lng();
            });

            map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById("location").value = event.latLng.lat() + ', ' + event.latLng.lng();
            });
        }
        function getAddress(latitude, longitude, id) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    let address = data.display_name;
                    document.getElementById(`lokasi-${id}`).textContent = address;
                    document.getElementById('location').value = address;
                }
            })
            .catch(error => {
                console.error('Error fetching address:', error);
        });
    }
</script>
@section('content')
<div class="box">
    <div class="box-header with-border" style="justify-content: space-between; display: flex;">
        <h3 class="box-title">Data Ambulans</h3>
        @if(auth()->user()->role == 'driver')
            <button type="button" class="btn btn-primary" onclick="add_ajax()">
                <i class="ti-plus"></i>
                Tambah
            </button>
        @endif
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nomor Plat Ambulans</th>
                        <th>Biaya/Tarif</th>
                        <th>Fasilitas Ambulans</th>
                        <th>Lokasi</th>
                        <th>Ambulans Milik</th>
                        <th>Nomor Whatsapp</th>
                        <th>Foto</th>
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
                        <td>{!! $row->fasilitas !!}</td>
                        <td id="lokasi-{{ $row->ambulan_id }}" style="width: 400px; white-space: normal;">{{ $row->lokasi }}</td>
                        <td>{{ $row->milik }}</td>
                        <td>{{ $row->no_hp }}</td>
                        <td><img src="{{ Storage::url($row->gambar) }}" alt="product" width="50" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewImage{{ $row->ambulan_id }}">
                            <div class="modal fade" id="viewImage{{ $row->ambulan_id }}" tabindex="-1" aria-labelledby="viewImageModalLabel{{ $row->ambulan_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewImageModalLabel{{ $row->ambulan_id }}">Foto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ Storage::url($row->gambar) }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($row->status == 'Diterima')
                                <button type="button" class="btn btn-success btn-sm">
                                    {{ $row->status }}
                                </button>
                            @elseif ($row->status == 'Ditolak')
                                <button type="button" class="btn btn-danger btn-sm">
                                    {{ $row->status }}
                                </button>
                            @elseif ($row->status == 'Pending')
                                <button type="button" class="btn btn-warning btn-sm">
                                    {{ $row->status }}
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm">
                                    {{ $row->status }}
                                </button>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0)" onclick="edit('{{ $row->ambulan_id }}')" class="text-info me-10"><i class="ti-marker-alt"></i></a>
                            <a href="javascript:void(0)" onclick="hapus('{{ $row->ambulan_id }}')" class="text-danger"><i class="ti-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Form Data Ambulans</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form class="form" action="" method="POST" id="formAdd" enctype="multipart/form-data">
                                <input type="hidden" name="ambulan_id" value="">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h5>Upload Surat Izin Oprasional <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="file" name="surat_izin" class="form-control" required>
                                            </div>
                                            <div class="form-control-feedback"><small>Upload dalam bentuk jpg <code>max 1MB</code></small></div>
                                        </div>
                                        <div class="form-group">
                                            <h5>Upload Foto Mobil Ambulan <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="file" name="gambar" class="form-control" required>
                                            </div>
                                            <div class="form-control-feedback"><small>Upload dalam bentuk jpg <code>max 1MB</code></small></div>
                                        </div>
                                        <div class="form-group">
                                            <h5>Masukkan Nomor Plat Mobil Ambulan <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="no_plat" class="form-control" required placeholder="Nomor Plat">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h5>Biaya/Tarif <span class="text-danger">*</span></h5>
                                            <div class="input-group"> <span class="input-group-addon">RP</span>
                                                <input type="number" name="biaya" class="form-control" required data-validation-required-message="This field is required" placeholder="Biaya">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="fasilitas" class="form-label">Fasilitas</label>
                                            <textarea id="fasilitas" name="fasilitas" class="form-control" placeholder="Masukkan Fasilitas" data-parsley-required="true"  rows="5" cols="15"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h5>Lokasi <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <div id="map" style="height: 400px; width: 100%; margin-bottom: 10px;"></div>
                                                <input type="text" id="location" name="lokasi" class="form-control" required placeholder="Lokasi" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Milik</label>
                                        <select class="form-select" name="milik">
                                            <option value="Pribadi">Pribadi</option>
                                            <option value="Organiasi">Organiasi</option>
                                            <option value="Rumah Sakit">Rumah Sakit</option>
                                        </select>
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
<script src="{{asset('assets/vendor_components/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    // CKEDITOR.replace('editor1', {
    //   toolbar: [
    //     { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
    //     { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
    //     { name: 'styles', items: ['Format'] },
    //     { name: 'links', items: ['Link', 'Unlink'] },
    //     { name: 'tools', items: ['Maximize'] },
    //     { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Undo', 'Redo'] }
    //   ]
    // });
    document.addEventListener('DOMContentLoaded', function () {
        let textarea = document.getElementById('fasilitas');
        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent the default action (new line)
                let value = textarea.value;
                let lines = value.split('\n').filter(line => line.trim() !== '');
                let numberedLines = lines.map((line, index) => (index + 1) + '. ' + line.replace(/^\d+\.\s*/, '')).join('\n');
                textarea.value = numberedLines + '\n' + (lines.length + 1) + '. ';
            }
        });
    });
    function resetForm() {
        $('#formAdd')[0].reset();
    }

    function add_ajax() {
        method = 'add';
        resetForm();
        $('#myModalLabel1').html("Tambah Ambulan");
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#m_modal').modal('show');
    }

    function save() {
        let url;

        if (method === 'add') {
            url = "{{ route('ambulan.store') }}";
        } else {
            url = "{{ route('ambulan.update') }}";
        }

        var formData = new FormData();
        formData.append('ambulan_id', $('[name="ambulan_id"]').val());
        formData.append('no_plat', $('[name="no_plat"]').val());
        formData.append('biaya', $('[name="biaya"]').val());
        formData.append('lokasi', $('[name="lokasi"]').val());
        formData.append('milik', $('[name="milik"]').val());
        formData.append('fasilitas', $('[name="fasilitas"]').val());
        // formData.append('fasilitas', CKEDITOR.instances.editor1.getData());
        formData.append('gambar', $('[name="gambar"]')[0].files[0]);
        formData.append('surat_izin', $('[name="surat_izin"]')[0].files[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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

        $('#myModalLabel1').html("Edit Ambulan");

        $.ajax({
            url: "{{ url('ambulan/edit') }}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.data) {
                    $('#formAdd')[0].reset();
                    $('[name="ambulan_id"]').val(data.data.ambulan_id);
                    $('[name="no_plat"]').val(data.data.no_plat);
                    $('[name="biaya"]').val(data.data.biaya);
                    $('[name="lokasi"]').val(data.data.lokasi);
                    $('[name="milik"]').val(data.data.milik);
                    let fasilitasHtml = data.data.fasilitas;
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = fasilitasHtml;
                    
                    let listItems = tempElement.getElementsByTagName('li');
                    let fasilitasText = '';
                    
                    for (let i = 0; i < listItems.length; i++) {
                        let text = listItems[i].innerText || listItems[i].textContent;
                        fasilitasText += (i + 1) + '. ' + text + '\n';
                    }
                    
                    $('[name="fasilitas"]').val(fasilitasText.trim());
                    // CKEDITOR.instances.editor1.setData(data.data.fasilitas);
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
                    url: "{{ url('ambulan') }}/" + id,
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