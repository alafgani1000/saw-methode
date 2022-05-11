<div class="modal-header">
    <h5 class="modal-title">Edit Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" id="formEditCategory" action="{{ route('category.update',$data->id) }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $data->name }}">
            <div id="helpEditCategoryName" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" id="description" value="{{ $data->description }}">
            <div id="helpEditCategoryDescription" class="help-validate">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formEditCategory" id="updateCategory" class="btn btn-primary">Update</button>
</div>
<script>
    $(function() {
        $('#formEditCategory').on('submit',function (e) {
            e.preventDefault();
            const url = $(this).attr('action');
            const data = $(this).serialize();
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
            }).done(function (res) {
                Toast.fire({
                    icon: 'success',
                    title: res
                });
                modalEditCategory.hide();
                dataCategory();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                });
                $('#helpEditCategoryName').text(errors.name);
                $('#helpEditCategoryDescription').text(errors.description);
            });
        });
    });
</script>
