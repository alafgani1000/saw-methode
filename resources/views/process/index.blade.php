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
                        <thead>
                            <tr>
                                <th>Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $title->text }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection
