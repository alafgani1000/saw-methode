<div class="modal-header">
    <h5 class="modal-title">Edit Criteria</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" id="formEditCriteria" action="{{ route('criteria.update',$data->id) }}">
        @csrf
        <input type="hidden" value="{{ $data->title_id }}" name="title" id="titleEditCriteria">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="nameEditCriteria" value="{{ $data->name }}">
            <div id="helpEditCriteriaName" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category" id="categoryEditCriteria">
                @foreach ($categories as $item)
                    @if($data->category_id == $item->id)
                        @php
                            $selected = 'selected';
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <option value="{{ $item->id }}" {{ $selected }}>{{ $item->name }}</option>
                @endforeach
            </select>
            <div id="helpEditCriteriaCategory" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <label for="percent" class="form-label">Percent</label>
            <input type="text" name="percent" class="form-control" id="percentEditCriteria" value="{{ $data->percent }}">
            <div id="helpEditCriteriaPercent" class="help-validate">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formEditCriteria" id="updateCriteria" class="btn btn-primary">Update</button>
</div>
<script>
    $(function() {
        $('#formEditCriteria').on('submit',function (e) {
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
                modalEditCriteria.hide();
                dataCriteria.ajax.reload();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                });
                $('#helpEditCriteriaName').text(errors.name);
                $('#helpEditCriteriaCategory').text(errors.category);
                $('#helpEditCriteriaPercent').text(errors.percent);
            });
        });
    })
</script>
