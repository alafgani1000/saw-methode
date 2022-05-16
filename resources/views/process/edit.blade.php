<div class="modal-header">
    <h5 class="modal-title">Edit Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="{{ route('transaction.store') }}" id="formEditTransaction">
        @csrf
        <input type="hidden" value="{{ $titleId }}" name="title" id="titleTransaction">
        <div class="mb-3">
            <label for="code" class="form-label">Alternative</label>
            <input class="form-control" name="name" value="{{ $alternatives->name }}">
            <div id="helpEditTransactionCode" class="help-validate">
            </div>
        </div>
        @foreach ($criterias as $item)
            @php
                $dtra = $transactions->where('attribute_id',$item->id)->first();
            @endphp
            <div class="mb-3">
                <label for="{{ $item->name }}" class="form-label">{{ $item->name }}</label>
                <input type="text" name="{{ Str::lower($item->id) }}" class="form-control" id="{{ Str::lower($item->name)  value="{{ isset($dtra->value) ? $dtra->value : 0 }}"}}">
                <div id="help.{{ Str::lower($item->name) }}" class="help-validate">
                </div>
            </div>
        @endforeach
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="formEditTransaction" id="saveCriteria" class="btn btn-primary">Save</button>
</div>
<script>
    $(function() {
        $('#formEditTransaction').on('submit',function (e) {
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
