@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start">Catgory</h5>
                    <button class="btn btn-sm btn-primary float-end" id="btnAddCategory">Add New</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data['name'] }}</td>
                                    <td>{{ $data['description'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
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
                        <input type="text" class="form-control" id="name" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" placeholder="">
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
<script>
    var modalAddCategory = new bootstrap.Modal(document.getElementById('modalAddCategory'), {
        keyboard: false
    });

    $(function() {
        $('#btnAddCategory').click(function (e) {
            e.preventDefault();
            modalAddCategory.show();
        });
        $("#formAddCategory").submit(function (e) {
            e.preventDefault();
            const method = $(this).attr('method');
            const url = $(this).attr('action');
            const data = $(this).serialize();
            $.ajax({
                type: method,
                url: url,
                data: data
            }).done(function (response) {

            }).fail(function () {

            });
        });
    })
</script>
@endsection
