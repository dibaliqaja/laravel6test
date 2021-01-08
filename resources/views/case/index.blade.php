@extends('layout_cms.home')
@section('title_page','Get Major Consume API')
@section('content')

    <div class="table-responsive">
        <table id="myTable" class="table table-hover table-bordered">
            <thead>
                <th width="5%">ID</th>
                <th>Name</th>
            </thead>
            <tbody id="majorBody"></tbody>
        </table>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'http://eannov8.com/career/case/getMajor.json',
            type: "GET",
            dataType: 'json',
            crossDomain: true,
            headers: {
                'Content-Type':'application/json',
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept',
            },
            success: function (result) {
                for (var d in result.data) {
                    var data = result.data[d];
                    $('#majorBody').append($('<tr>')
                        .append($('<td>', { text: data.id }))
                        .append($('<td>', { text: data.name }))
                    )
                }
            }
        });
    });
</script>
@endsection
