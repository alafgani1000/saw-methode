<div class="modal-header">
    <h5 class="modal-title">Add Criteria</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" id="formAddCriteria" action="{{ route('criteria.store') }}">
        @csrf
        <input type="hidden" value="{{ $title_id }}" name="titleCriteria">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="nameCriteria">
            <div id="helpAddCriteriaName" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control" name="catgory" id="categoryCriteria">
                <option value="">Please Select ...</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div id="helpAddCriteriaCategory" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="percent" class="form-label">Percent</label>
            <input type="text" name="percent" class="form-control" id="percentCriteria">
            <div id="helpAddCriteriaPercent" class="help-validate">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formAddCriteria" id="saveCriteria" class="btn btn-primary">Save</button>
</div>
<script>
    $(function() {
        $('#formAddCriteria').on('submit',function (e) {
            e.preventDefault();
            const url = $(this).attr('action');
            const data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: data,
            }).done(function (res) {
                Toast.fire({
                    icon: 'success',
                    title: res
                });
                modalAddCriteria.hide();
                dataCriteria.ajax.reload();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                });
                $('#helpAddCriteriaName').text(errors.name);
                $('#helpAddCriteriaCategory').text(errors.category);
                $('#helpAddCriteriaPercent').text(errors.percent);
            });
        });
    })
</script>
