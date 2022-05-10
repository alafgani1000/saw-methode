@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start">Category</h5>
                    <button class="btn btn-sm btn-primary float-end" id="btnAddCategory">Add New</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dataCategory">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalAddCategory">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="formAddCategory" action="{{ route('category.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" id="categoryName" placeholder="">
                        <div id="helpCategoryName" class="help-validate">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" id="categoryDescription" placeholder="">
                        <div id="helpCategoryDescription" class="help-validate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formAddCategory" id="saveCategory" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalEditCategory">
    <div class="modal-dialog">
        <div class="modal-content" id="modalEditCateContent">

        </div>
    </div>
</div>
<script>
    var modalAddCategory = new bootstrap.Modal(document.getElementById('modalAddCategory'), {
        keyboard: false
    });

    var modalEditCategory =  new bootstrap.Modal(document.getElementById('modalEditCategory'), {
        keyboard: false
    });

    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    function dataCategory() {
        $.ajax({
            type: 'GET',
            url: '{{ route("category.data") }}',
            data: {},
        }).done(function (res) {
            $('#dataCategory').html(res);
        }).fail(function (res) {
            Toast.fire({
                icon: 'error',
                title: res
            })
        });
    }

    $(function() {
        dataCategory();

        $('#btnAddCategory').click(function (e) {
            e.preventDefault();
            $('#categoryName').val('');
            $('#categoryDescription').val('');
            modalAddCategory.show();
        });

        $('#formAddCategory').on('submit', function (e) {
            e.preventDefault();
            const method = $(this).attr('method');
            const url = $(this).attr('action');
            const data = $(this).serialize();
            $.ajax({
                type: method,
                url: url,
                data: data,
            }).done(function (res) {
                Toast.fire({
                    icon: 'success',
                    title: res
                });
                modalAddCategory.hide();
                dataCategory();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                })
                $('#helpCategoryName').text(errors.name);
                $('#helpCategoryDescription').text(errors.description);
            });
        });
    })
</script>
@endsection
