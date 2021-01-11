@extends('layout_cms.home')
@section('title_page','Majors')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <a href="javascript:void(0)" class="btn btn-primary" id="create-new-major" onclick="addMajor()">Add Major</a><br>
        </div>
    </div>
    <br>

    <div class="table-responsive">
        <table id="major-table" class="table table-hover table-bordered">
            <thead>
                <tr center>
                    <th width="5%">ID</th>
                    <th>Title</th>
                    <th>Major</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($majors as $index => $major)
                <tr id="row_{{ $major->id }}">
                    <td>{{ $major->id }}</td>
                    <td>{{ $major->title }}</td>
                    <td>{{ $major->major }}</td>
                    <td align="center">
                        <a href="javascript:void(0)" data-id="{{ $major->id }}" onclick="editMajor(event.target)" class="btn btn-sm btn-info">Edit</a>
                        <a href="javascript:void(0)" data-id="{{ $major->id }}" onclick="deleteMajor(event.target)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $majors->links() }}
    </div>

@endsection

@section('modal')
    <!-- Modal Major -->
    <div class="modal fade" id="major-modal" tabindex="-1" role="dialog" aria-hidden="true">
    {{-- <div class="modal fade" id="major-modal" aria-hidden="true"> --}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Create/Update Major</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="majorForm" class="form-horizontal">
                        <input type="hidden" name="major_id" id="major_id">
                        <div class="form-group">
                            <label for="title" class="col-sm-2">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                                <span id="titleError" class="alert-message text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="major" class="col-sm-2">Major</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="major" name="major" placeholder="Enter major">
                                <span id="majorError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="createMajor()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    function addMajor() {
        $('#title').val('');
        $('#major').val('');
        $('#titleError').text('');
        $('#majorError').text('');
        $('#major-modal').modal('show');
    }

    function editMajor(event) {
        var id  = $(event).data("id");
        let _url = `/majors/${id}`;
        $('#titleError').text('');
        $('#majorError').text('');

        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                console.log(response)
                if(response) {
                    $("#major_id").val(response.id);
                    $("#title").val(response.title);
                    $("#major").val(response.major);
                    $('#major-modal').modal('show');
                }
            }
        });
    }

    function createMajor() {
        var title = $('#title').val();
        var major = $('#major').val();
        var id = $('#major_id').val();

        let _url     = `/majors`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                title: title,
                major: major,
                _token: _token
            },
            success: function(response) {
                if(response.status == 200) {
                    if(id != ""){
                        $("#row_"+id+" td:nth-child(2)").html(response.data.title);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.major);
                    } else {
                        $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.title+'</td><td>'+response.data.major+'</td><td align="center"><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editMajor(event.target)" class="btn btn-sm btn-info">Edit</a> <a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-sm btn-danger" onclick="deleteMajor(event.target)">Delete</a></td></tr>');
                    }
                    $('#title').val('');
                    $('#major').val('');

                    $('#major-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#titleError').text(response.responseJSON.errors.title);
                $('#majorError').text(response.responseJSON.errors.major);
            }
        });
    }

    function deleteMajor(event) {
        var id  = $(event).data("id");
        let _url = `/majors/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        if(confirm('Are you sure?')) {
            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $("#row_"+id).remove();
                    console.log(response);
                },
                error : (error) => {
                    if (error.status === 500) {
                        alert('Major still used in Student');
                    }
                    console.log(JSON.stringify(error));
                }
            });
        }
    }
</script>
@endsection
