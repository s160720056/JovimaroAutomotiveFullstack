@extends('layouts.app')

@section('title', 'Data Mobil')

@section('content')


    <h4>Data Pemilik Mobil</h4>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
        Tambah Mobil
    </button>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Data Mobil</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="car-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pemilik</th>
                            <th>Merk</th>
                            <th>Warna</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- filter input nama pemilik,merk --}}
    <div class="row mt-4">
        <div class="col-12">
            <h6 class="mb-2">Nama Pemilik</h6>
            <input type="text" class="form-control" id="owner_filter" name="owner_filter" style="width: 30%;"
                placeholder="Masukkan Nama Pemilik">
        </div>
        <div class="col-12 mt-4">
            <h6 class="mb-2">Merk Mobil</h6>
            <input type="text" class="form-control" id="brand_filter" name="brand_filter" style="width: 30%;"
                placeholder="Masukkan Merk Mobil">
        </div>
        <div class="col-12 mt-3">
            <button type="button" class="btn btn-primary" style="width: 30%;" id="filter-btn">Filter</button>

        </div>
        <div class="col-12 mt-3">
            <button type="button" class="btn btn-secondary" id="reset-filter" style="width:30%">Reset</button>
        </div>

    </div>




    <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Tambah Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCarForm" method="POST" action="{{ route('cars.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="owner_id" class="form-label">Pemilik</label>
                            <select class="form-control" id="owner_id" name="owner_id" required>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Merk</label>
                            <select class="form-control" id="brand_id" name="brand_id" required>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Warna</label>
                            <input type="text" class="form-control" id="color" name="color" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCarModalLabel">Edit Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCarId" name="id">
                    <div class="mb-3">
                        <label for="editOwnerId" class="form-label">Pemilik</label>
                        <select class="form-control" id="editOwnerId" name="owner_id" required>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editBrandId" class="form-label">Merk</label>
                        <select class="form-control" id="editBrandId" name="brand_id" required>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editColor" class="form-label">Warna</label>
                        <input type="text" class="form-control" id="editColor" name="color" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" id="editCarSubmit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            let table = $('#car-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route('cars.data') }}',
                    type: 'GET',
                    data: function(d) {
                        d.owner = $('#owner_filter').val();
                        d.brand = $('#brand_filter').val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'owner.name',
                        title: 'Pemilik'
                    },
                    {
                        data: 'brand.brand_name',
                        title: 'Merk'
                    },
                    {
                        data: 'color',
                        title: 'Warna'
                    },
                    {
                        data: 'owner.address',
                        title: 'Alamat'
                    },
                    {
                        data: 'description',
                        title: 'Keterangan'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            window.editCar = function(id) {
                axios.get('{{ route('cars.edit', ':id') }}'.replace(':id', id))
                    .then(function(response) {
                        $('#editCarId').val(response.data.id);
                        $('#editOwnerId').val(response.data.owner_id);
                        $('#editBrandId').val(response.data.brand_id);
                        $('#editColor').val(response.data.color);
                        $('#editDescription').val(response.data.description);
                        $('#editCarModal').modal('show');
                    });
            }

            window.deleteCar = function(id) {
                Swal.fire({
                    title: 'Apakah yakin ingin menghapus mobil ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('{{ route('cars.destroy') }}', {
                            id: id
                        }).then(function(response) {
                            if (response.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.data.success,
                                });
                                table.ajax.reload(null, false);
                            } else if (response.data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.data.error,
                                });
                            }
                        });
                    }
                });
            }


            $('#editCarSubmit').click(function(e) {
                e.preventDefault();
                axios.post('{{ route('cars.update') }}', {
                    id: $('#editCarId').val(),
                    owner_id: $('#editOwnerId').val(),
                    brand_id: $('#editBrandId').val(),
                    color: $('#editColor').val(),
                    description: $('#editDescription').val(),
                }).then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.success,
                        });
                        table.ajax.reload(null, false);
                        $('#editCarModal').modal('hide');
                    } else if (response.data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.data.error,
                        });
                    }
                });
            });

            $('#filter-btn').click(function() {
                table.ajax.reload();
            });
            $('#reset-filter').on('click', function() {
                $('#owner_filter').val('');
                $('#brand_filter').val('');
                table.ajax.reload();
            });

        });
    </script>
@endsection
