@extends('layouts.app')

@section('title', 'Data Merk Brand')

@section('content')

   

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- button modal --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
        Tambah Brand
    </button>
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Data brands</h5>
        </div>
        <div class="card-body">
  
     <div class="table-responsive">
        <table id="brand-table" class="table table-bordered"  style="width:100%">
        <thead>
            <tr>
                <th class="text-center">Merk</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- data --}}
        </tbody>
    </table>
</div>
</div>
    

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Tambah Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBrandForm" method="POST" action="{{ route('brands.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Nama Brand</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit brand --}}
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <input type="hidden" id="editBrandId" name="id">
                        <div class="mb-3">
                            <label for="editBrandName" class="form-label">Nama Brand</label>
                            <input type="text" class="form-control" id="editBrandName" name="brand_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editBrandSubmit">Update</button>
                        </div>
                </div>
            </div>
        </div>
    </div>



    

<script>
$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    const table = $('#brand-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('brands.data') }}',
            type: 'GET',
        },
        columns: [
            { data: 'brand_name', name: 'brand_name', className: 'text-center' },
            {
                data: 'action',
                name: 'action',
                className: 'text-center',
                orderable: false,
                searchable: false
            }
        ],
    });

    window.editBrand = function (id) {
        axios.get('{{ route('brands.edit', ['brand' => ':id']) }}'.replace(':id', id))
            .then(function (response) {
                $('#editBrandId').val(response.data.id);
                $('#editBrandName').val(response.data.brand_name);
                $('#editBrandModal').modal('show');
            });
    }

    $('#editBrandSubmit').click(function (e) {
     const id_brand=$('#editBrandId').val();
     const brand_name=$('#editBrandName').val();
     axios.post('{{ route('brands.update') }}', {
        id: id_brand,
        brand_name: brand_name,
     })
    .then(function (response) {
        if (response.data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.data.success,
            });
        } else if (response.data.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.data.error,
            });
        }
         table.ajax.reload();
         $('#editBrandModal').modal('hide');
    });
    });

    window.deleteBrand = function (id) {
        alert(id);
       Swal.fire({
        title: 'Apakah yakin ingin menghapus brand ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
       }).then((result) => {
        if (result.isConfirmed) {
            axios.post('{{ route('brands.destroy') }}', {
                id: id
            }).then(function (response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.success,
                    });
                    table.ajax.reload();
                } else if (response.data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.data.error,
                    });
                }
            });
        }
       })
    }




});
</script>
@endsection





