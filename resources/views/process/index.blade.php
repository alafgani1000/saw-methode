@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start">SAW Methode</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="tableDataTitle">
                        <tbody>
                            <tr>
                                <td>{{ $title->text }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="alternative-tab" data-bs-toggle="tab" data-bs-target="#alternative" type="button" role="tab" aria-controls="alternative" aria-selected="true">Alternative</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active mt-3" id="alternative" role="tabpanel" aria-labelledby="alternative-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="float-start">Data Alaternative</h6>
                                    <button class="btn btn-primary float-end" id="btnAddAlternative">Add New</button>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tableDataAlternative">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Profile</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalAddAlternative">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Alternative</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="formAddAlternative" action="{{ route('title.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="alternativeCode">
                        <div id="helpAlternativeCode" class="help-validate">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="alternativeName">
                        <div id="helpAlternativeName" class="help-validate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formAddAlternative" id="saveTitle" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    var modalAddAlternative = new bootstrap.Modal(document.getElementById('modalAddAlternative'), {
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

    $(function() {
        dataAlternative = $('#tableDataAlternative').DataTable({
            'processing':true,
            'serverSide':true,
            'ajax':'{{ route("alternative.data") }}',
            'dom':'Bfrtip',
            'buttons': [
                'copy', 'csv', 'excel', 'pdf', 'print','pageLength'
            ],
            lengthMenu: [
                [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            'columns':[
                {'data':'code'},
                {'data':'name'},
                {'data':'id', render:function(data){
                    return '<div class="btn-group"><button dataid="'+data+'" class="btn btn-warning btn-sm cat-btn-edit text-white">Edit</button ><button dataid="'+data+'" class="btn btn-danger btn-sm cat-btn-delete">Delete</button></div>'
                }}
            ]
        })

        $('#btnAddAlternative').click(function (e) {
            modalAddAlternative.show();
            $('#alternativeCode').val('');
            $('#alternativeName').val('');
            $('#helpAlternativeCode').text('');
            $('#helpAlternativeName').text('');
        });

        $('#formAddAlternative').on('submit', function(e) {
            e.preventDefault();
            const url = $(this).attr('action');
            const data = $(this).serialize();
            const method = $(this).attr('method');
            $.ajax({
                type: method,
                url: url,
                data: data,
            }).done(function (res) {
                Toast.fire({
                    icon: 'success',
                    title: res
                });
                modalAddAlternative.hide();
                dataAlternative.ajax.reload();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: 'Input failed'
                })
                let errors = res.responseJSON.errors;
                $('#helpAlternativeCode').text(errors.code);
                $('#helpAlternativeName').text(errors.name);
            });
        });
    });
</script>
@endsection
