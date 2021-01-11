@extends('layout_cms.home')
@section('title_page','Majors')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <a href="javascript:void(0)" id="createNewMajor" class="btn btn-primary">Add Major</a>
        </div>
    </div>
    <br>

    <div class="table-responsive">
        <table id="major-table" class="table table-hover table-bordered">
            <thead>
                <tr center>
                    <th width="5%">No</th>
                    <th>Title</th>
                    <th>Major</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@section('modal')
<!-- Modal Major -->
<div class="modal fade" id="ajaxModel" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="majorForm" name="majorForm" class="form-horizontal">
                   <input type="hidden" name="major_id" id="major_id">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                            <span id="titleError" class="alert-message text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="major" class="col-sm-2 control-label">Major</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="major" name="major" placeholder="Enter major" required>
                            <span id="majorError" class="alert-message text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#major-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('majors.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'major', name: 'major'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewMajor').click(function () {
            $('#saveBtn').val("create-major");
            $('#major_id').val('');
            $('#majorForm').trigger("reset");
            $('#modelHeading').html("Create New Major");
            $('#titleError').text('');
            $('#majorError').text('');
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editMajor', function () {
            var major_id = $(this).data('id');
            let _url = `/majors/${major_id}/edit`;
            $.get(_url, function (data) {
                $('#modelHeading').html("Edit Major");
                $('#titleError').text('');
                $('#majorError').text('');
                $('#saveBtn').val("edit-major");
                $('#ajaxModel').modal('show');
                $('#major_id').val(data.id);
                $('#title').val(data.title);
                $('#major').val(data.major);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#majorForm').serialize(),
                url: "{{ route('majors.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#majorForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#titleError').text(data.responseJSON.errors.title);
                    $('#majorError').text(data.responseJSON.errors.major);
                }
            });
        });

        $('body').on('click', '.deleteMajor', function () {
            var major_id = $(this).data("id");
            let _url = `/majors/${major_id}`;

            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: _url,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        if (data.status == 500) {
                            alert('Major still used in student');
                        }
                        console.log('Error:', data);
                    }
                });
            }
        });

 });
</script>
@endsection
