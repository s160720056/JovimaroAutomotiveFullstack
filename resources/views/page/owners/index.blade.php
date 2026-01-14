@extends('layouts.app')

@section('title', 'Data Pemilik')

@section('content')

    <h4>Data Pemilik</h4>

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

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addOwnerModal">
        Tambah Pemilik
    </button>
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Data Owners</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="owner-table" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama Pemilik</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- Modal Tambah --}}
    <div class="modal fade" id="addOwnerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pemilik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('owners.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label>Nama Pemilik</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-2">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="mb-2">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="note"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editOwnerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pemilik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editOwnerId">
                    <div class="mb-2">
                        <label>Nama Pemilik</label>
                        <input type="text" id="editOwnerName" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Alamat</label>
                        <input type="text" id="editOwnerAddress" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Keterangan</label>
                        <textarea id="editOwnerNote" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="editOwnerSubmit">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const table = $('#owner-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('owners.data') }}',
                columns: [{
                        data: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'address',
                        className: 'text-center'
                    },
                    {
                        data: 'note',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            window.editOwner = function(id) {
                axios.get('{{ route('owners.edit', ':id') }}'.replace(':id', id))
                    .then(res => {
                        $('#editOwnerId').val(res.data.id);
                        $('#editOwnerName').val(res.data.name);
                        $('#editOwnerAddress').val(res.data.address);
                        $('#editOwnerNote').val(res.data.note);
                        $('#editOwnerModal').modal('show');
                    });
            }

            $('#editOwnerSubmit').click(function() {
                axios.post('{{ route('owners.update') }}', {
                    id: $('#editOwnerId').val(),
                    name: $('#editOwnerName').val(),
                    address: $('#editOwnerAddress').val(),
                    note: $('#editOwnerNote').val(),
                }).then(res => {
                    Swal.fire('Success', res.data.success, 'success');
                    table.ajax.reload();
                    $('#editOwnerModal').modal('hide');
                });
            });

            window.deleteOwner = function(id) {
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.post('{{ route('owners.destroy') }}', {
                                id
                            })
                            .then(() => table.ajax.reload());
                    }
                });
            }

        });
    </script>
@endsection
