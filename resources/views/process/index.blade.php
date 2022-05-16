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
                            <button class="nav-link" id="criteria-tab" data-bs-toggle="tab" data-bs-target="#criteria" type="button" role="tab" aria-controls="criteria" aria-selected="false">Criteria</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false">Data SAW</button>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-3" id="criteria" role="tabpanel" aria-labelledby="criteria-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="float-start">Data Criteria</h6>
                                    <button class="btn btn-primary float-end" id="btnAddCriteria">Add New</button>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tableDataCriteria" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Percent</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-3" id="data" role="tabpanel" aria-labelledby="data-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="float-start">Data Transaction</h6>
                                    <div class="btn-group  float-end">
                                        <button class="btn btn-primary" id="btnAddTransaction">Add New</button>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <table class="table" id="tableDataTransaction" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                @foreach ($criterias as $item)
                                                    <th>{{ $item->name }}</th>
                                                @endforeach
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- start modal alternative --}}
<div class="modal" tabindex="-1" id="modalAddAlternative">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Alternative</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="formAddAlternative" action="{{ route('alternative.store') }}">
                    @csrf
                    <input type="hidden" name="title_id" value="{{ $title->id }}">
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
<div class="modal" tabindex="-1" id="modalEditAlternative">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContEditAlternative">

        </div>
    </div>
</div>
{{-- end modal alternative --}}
{{-- start modal criteria --}}
<div class="modal" tabindex="-1" id="modalAddCriteria">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContAddCriteria">

        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalEditCriteria">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContEditCriteria">

        </div>
    </div>
</div>
{{-- end modal criteria --}}
{{-- start modal transaction --}}
<div class="modal" tabindex="-1" id="modalAddTransaction">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContAddTransaction">

        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalEditTransaction">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContEditTransaction">

        </div>
    </div>
</div>
{{-- end modal transaction --}}
<script>
    var modalAddAlternative = new bootstrap.Modal(document.getElementById('modalAddAlternative'), {
        keyboard: false
    });

    var modalEditAlternative = new bootstrap.Modal(document.getElementById('modalEditAlternative'), {
        keyboard: false
    });

    var modalAddCriteria = new bootstrap.Modal(document.getElementById('modalAddCriteria'), {
        keyboard: false
    });

    var modalEditCriteria = new bootstrap.Modal(document.getElementById('modalEditCriteria'), {
        keyboard: false
    });

    var modalAddTransaction = new bootstrap.Modal(document.getElementById('modalAddTransaction'), {
        keyboard: false
    });

    var modalEditTransaction = new bootstrap.Modal(document.getElementById('modalEditTransaction'), {
        keyboard: false
    })

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

    const testData = [
        {'data':'code'},
        {'data':'name'},
        {'data':'data.Absensi'},
        {'data':'data.Performa'}
    ];

    $(function() {
        dataAlternative = $('#tableDataAlternative').DataTable({
            'processing':true,
            'serverSide':true,
            'ajax':'{{ route("alternative.data", $title->id) }}',
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
                    return '<div class="btn-group"><button dataid="'+data+'" class="btn btn-warning btn-sm alter-btn-edit text-white">Edit</button ><button dataid="'+data+'" class="btn btn-danger btn-sm alter-btn-delete">Delete</button></div>'
                }}
            ]
        });

        dataCriteria = $('#tableDataCriteria').DataTable({
            'processing':true,
            'serverSide':true,
            'ajax':'{{ route("criteria.data", $title->id) }}',
            'dom':'Bfrtip',
            'buttons': [
                'copy', 'csv', 'excel', 'pdf', 'print','pageLength'
            ],
            lengthMenu: [
                [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            'columns':[
                {'data':'name'},
                {'data':'category.name'},
                {'data':'percent'},
                {'data':'id', render:function(data){
                    return '<div class="btn-group"><button dataid="'+data+'" class="btn btn-warning btn-sm criteria-btn-edit text-white">Edit</button ><button dataid="'+data+'" class="btn btn-danger btn-sm criteria-btn-delete">Delete</button></div>'
                }}
            ]
        });

        dataTransaction = null;
        $.ajax({
            url: '{{ route("transaction.column", $title->id) }}',
            type: 'GET',
            success: function (res) {
                let column = res
                column.push( {'data':'id', render:function(data){
                    return '<div class="btn-group"><button dataid="'+data+'" class="btn btn-warning btn-sm tra-btn-edit text-white">Edit</button ><button dataid="'+data+'" class="btn btn-danger btn-sm tra-btn-delete">Delete</button></div>'
                }})
                dataTransaction = $('#tableDataTransaction').DataTable({
                    'processing':true,
                    'serverSide':true,
                    'ajax':'{{ route("transaction.data", $title->id) }}',
                    'dom':'Bfrtip',
                    'buttons': [
                        'copy', 'csv', 'excel', 'pdf', 'print','pageLength'
                    ],
                    lengthMenu: [
                        [10, 25, 50, -1], [10, 25, 50, 'All']
                    ],
                    'columns':column
                });

            }
        })

        $("#tableDataAlternative_filter").addClass('float-end mb-2');
        $(".dt-buttons").css("margin-bottom","0 !important")
        $(".dt-buttons").addClass('float-start mb-0 pb-0');

        $("#tableDataCriteria_filter").addClass('float-end mb-2');
        $(".dt-buttons").css("margin-bottom","0 !important")
        $(".dt-buttons").addClass('float-start mb-0 pb-0');

        $('#btnAddTransaction').on('click', function (e) {
            let url = '{{ route('transaction.create',$title->id) }}';
            $.ajax({
                type:'GET',
                url: url,
                data: {}
            }).done(function (res) {
                $('#modalContAddTransaction').html(res);
                modalAddTransaction.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: res
                });
            });
        });

        $('#tableDataTransaction').on('click','.tra-btn-edit', function (e) {
            let dataId = $(this).attr('dataid');
            let url = '{{ route("transaction.edit", [$title->id,":dataId"]) }}';
            url = url.replace(':dataId', dataId);
            $.ajax({
                type:'GET',
                url: url,
                data: {}
            }).done(function (res) {
                $('#modalContEditTransaction').html(res);
                modalEditTransaction.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: res
                });
            });
        })

        $('#btnAddCriteria').on('click', function (e) {
            let url = '{{ route('criteria.create', $title->id) }}';
            $.ajax({
                type: 'GET',
                url: url,
                data: {},
            }).done(function (res) {
                $('#modalContAddCriteria').html(res);
                modalAddCriteria.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: res
                });
            });
        });

        $('#tableDataCriteria').on('click','.criteria-btn-edit',function (e) {
            let dataId = $(this).attr('dataid');
            let url = '{{ route("criteria.edit", ":dataId") }}';
            url = url.replace(':dataId', dataId);
            $.ajax({
                type: 'GET',
                url: url,
                data: {},
            }).done(function (res) {
                $('#modalContEditCriteria').html(res);
                modalEditCriteria.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                });
            });
        });

        $('#tableDataCriteria').on('click','.criteria-btn-delete',function (e) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                preConfirm: () => {
                    let dataId = $(this).attr('dataid');
                    let url = '{{ route("criteria.delete", ":dataId") }}';
                    url = url.replace(':dataId', dataId);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).done(function (res) {
                        Toast.fire({
                            icon: 'success',
                            title: res
                        });
                        dataCriteria.ajax.reload();
                    }).fail(function (res) {
                        Toast.fire({
                            icon: 'error',
                            title: res
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Criteria data has been deleted.',
                    'success'
                    )
                }
            })
        });

        $('#tableDataAlternative').on('click','.alter-btn-edit',function (e) {
            let dataId = $(this).attr('dataid');
            let url = '{{ route("alternative.edit", ":dataId") }}';
            url = url.replace(':dataId', dataId);
            $.ajax({
                type: "GET",
                url: url,
                data: {},
            }).done(function (res) {
                $('#modalContEditAlternative').html(res);
                modalEditAlternative.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: res
                });
            });
        });

        $('#tableDataAlternative').on('click', '.alter-btn-delete', function (e) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                preConfirm: () => {
                    let dataId = $(this).attr('dataid');
                    let url = '{{ route("alternative.delete", ":dataId") }}';
                    url = url.replace(':dataId', dataId);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).done(function (res) {
                        Toast.fire({
                            icon: 'success',
                            title: res
                        });
                        dataAlternative.ajax.reload();
                    }).fail(function (res) {
                        Toast.fire({
                            icon: 'error',
                            title: res
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Category data has been deleted.',
                    'success'
                    )
                }
            })
        });

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
