@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start">Category</h5>
                    <button class="btn btn-sm btn-primary float-end" id="btnAddTitle">Add New</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Text</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="dataTitle">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalAddTitle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="formAddTitle" action="{{ route('title.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="text" class="form-label">Text</label>
                        <input type="text" name="text" class="form-control" id="titleText" placeholder="">
                        <div id="helpTitleText" class="help-validate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formAddTitle" id="saveTitle" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalEditTitle">
    <div class="modal-dialog">
        <div class="modal-content" id="modalEditContTitle">

        </div>
    </div>
</div>
<script>
    var modalAddTitle = new bootstrap.Modal(document.getElementById('modalAddTitle'), {
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

    function dataTitle() {
        $.ajax({
            type: 'GET',
            url: '{{ route("title.data") }}',
            data: {},
        }).done(function (res) {
            $('#dataTitle').html(res);
        }).fail(function (res) {
            Toast.fire({
                icon: 'error',
                title: res
            })
        });
    }

    $(function() {
        dataTitle();

        $('#btnAddTitle').click(function (e) {
            e.preventDefault();
            $('#titleText').val('');
            modalAddTitle.show();
        });

        $('#formAddTitle').on('submit', function (e) {
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
                modalAddTitle.hide();
                dataTitle();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                })
                $('#helpTitleText').text(errors.text);
            });
        });
    })
</script>
@endsection
