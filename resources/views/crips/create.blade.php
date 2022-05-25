<div class="modal-header">
    <h5 class="modal-title">Add Data Crips</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="{{ route('transaction.store') }}" id="formAddCrips">
        @csrf
        <div class="mb-3">
            <label for="criteria" class="form-label">Criteria</label>
            <select name="criteria" class="form-select" id="criteriaId">
                <option>Please select...</option>
                @foreach ($criteria as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div id="helpAddCripsCode" class="help-validate">
            </div>
        </div>
        <div class="mb-3">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnAdd">Add</button>
                <button type="button" class="btn btn-sm btn-danger" id="btnDelete">Delete</button>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col">Start Value</div>
                <div class="col">Operator</div>
                <div class="col">End Value</div>
            </div>
            <div id="dataCrips">

            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formAddTransaction" id="saveCriteria" class="btn btn-primary">Save</button>
</div>
<script>
    $(function () {
        $('#btnAdd').click(function (e) {
            e.preventDefault();
            let component = $('#container-data-crips > .data-crips')
            $('#dataCrips').append('<div class="row data-component mb-1 mt-1"><div class="col"><input type="text" class="form-control"></div><div class="col"><select class="form-select"><option> <= </option><option> >= </option><option> > </option><option> < </option><option> = </option></select></div><div class="col"><input type="text" class="form-control"></div</div>');

        });
        $('#btnDelete').click(function (e) {
            e.preventDefault();
            $('#dataCrips').children().last().remove();
        })
    })
</script>
