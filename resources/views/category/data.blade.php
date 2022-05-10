@foreach ($datas as $data)
    <tr>
        <td>{{ $data['name'] }}</td>
        <td>{{ $data['description'] }}</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-sm btn-warning editCategory text-white" data-id="{{ $data->id }}">Edit</button>
                <button class="btn btn-sm btn-danger deleteCategory text-white" data-id="{{ $data->id }}">Delete</button>
            </div>
        </td>
    </tr>
@endforeach
<script>
    $(function() {
        $('.editCategory').on('click', function (e) {
            let dataId = $(this).attr('data-id');
            let url = '{{ route("category.edit", ":dataId") }}';
            url = url.replace(':dataId', dataId);
            $.ajax({
                type: "GET",
                url: url,
                data: {},
            }).done(function (res) {
                $('#modalEditCateContent').html(res);
                modalEditCategory.show();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                })
            });
        });

        $('.deleteCategory').on('click', function (e) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                preConfirm: () => {
                    let dataId = $(this).attr('data-id');
                    let url = '{{ route("category.delete", ":dataId") }}';
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
                        dataCategory();
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
    });
</script>
