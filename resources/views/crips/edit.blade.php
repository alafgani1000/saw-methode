<div class="modal-header">
    <h5 class="modal-title">Edit Data Crips</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="{{ route('crips.update', $crip->id) }}" id="formEditCrips">
        @csrf
        <div class="mb-3">
            <label for="criteria" class="form-label">Crips</label>
            <textarea name="datacrips" class="form-control" cols="3" rows="5">{{ $crip->data_crips }}</textarea>
            <div id="helpEditDataCrips" class="help-validate">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formEditCrips" id="updateCrips" class="btn btn-primary">Update</button>
</div>
<script>
    $(function () {
        $('#formEditCrips').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();
            $.ajax({
                type: "PUT",
                url: url,
                data: data
            }).done(function (res) {
                modalEditCrips.hide();
                Toast.fire({
                    icon: 'success',
                    title: 'Update Success'
                })
                dataCrips.ajax.reload();
            }).fail(function (res) {
                Toast.fire({
                    icon: 'error',
                    title: res
                })
            });
        });
    })
</script>
