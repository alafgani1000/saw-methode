<div class="modal-header">
    <h5 class="modal-title">Edit Alternative</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" id="formEditAlternative" action="{{ route('alternative.update', $data->id) }}">
        @csrf
        <input type="hidden" name="title_id" value="{{ $data->title_id }}">
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" id="alternativeCode" value="{{ $data->code }}">
            <div id="helpEditAlternativeCode" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="alternativeName" value="{{ $data->name }}">
            <div id="helpEditAlternativeName" class="help-validate">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formEditAlternative" id="saveTitle" class="btn btn-primary">Save</button>
</div>
<script>
    $(function() {
        $('#formEditAlternative').on('submit',function (e) {
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
                modalEditAlternative.hide();
                dataAlternative.ajax.reload();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: res
                });
                $('#helpEditAlternativeCode').text(errors.code);
                $('#helpEditAlternativeName').text(errors.name);
            });
        });
    });
</script>
