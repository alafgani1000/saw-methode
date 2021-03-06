<div class="modal-header">
    <h5 class="modal-title">Add Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="{{ route('transaction.store') }}" id="formAddTransaction">
        @csrf
        <input type="hidden" value="{{ $titleId }}" name="title" id="titleTransaction">
        <div class="mb-3">
            <label for="code" class="form-label">Alternative</label>
            <select name="code" class="form-select" id="codeTransaction">
                <option>Please select...</option>
                @foreach ($alternatives as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} | {{ $item->code }}</option>
                @endforeach
            </select>
            <div id="helpAddTransactionCode" class="help-validate">
            </div>
        </div>
        @foreach ($criterias as $item)
            <div class="mb-3">
                <label for="{{ $item->name }}" class="form-label">{{ $item->name }}</label>
                <input type="text" name="{{ Str::lower($item->id) }}" class="form-control" id="{{ Str::lower($item->name) }}">
                <div id="help.{{ Str::lower($item->name) }}" class="help-validate">
                </div>
            </div>
        @endforeach
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formAddTransaction" id="saveCriteria" class="btn btn-primary">Save</button>
</div>
<script>
    $(function() {
        $('#formAddTransaction').on('submit',function (e) {
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
                modalAddTransaction.hide();
                dataTransaction.ajax.reload();
            }).fail(function (res) {
                let errors = res.responseJSON.errors;
                Toast.fire({
                    icon: 'error',
                    title: 'Input Failed'
                });
            });
        });
    })
</script>
