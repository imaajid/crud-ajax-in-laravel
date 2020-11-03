<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Ajax CRUD Example Tutorial with - CodingDriver</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
</head>
<style>
    .alert-message {
        color: red;
    }
</style>
<body>

<div class="container">

    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-ajax" onclick="addajax()">Add ajax</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ajaxs as $ajax)
                    <tr>
                        <td>{{$ajax->id}}</td>
                        <td>{{$ajax->firstname}}</td>
                        <td>{{$ajax->lastname}}</td>
                        <td><a href="javascript:void(0)" data-id="{{$ajax->id}}" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{$ajax->id}}" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="ajax-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <form name="ajaxForm"  id="ajaxForm" class="form-horizontal">
                    <input type="hidden" name="ajax_id" id="ajax_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter ajax">
                            <span id="firstError" class="alert-message"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">last Name</label>
                        <div class="col-sm-12">
                        <input class="form-control" id="lastname" name="lastname" placeholder="Enter lastname" >

                            <span id="lastError" class="alert-message"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBtn" >Save</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    function addajax() {
        $("#ajax_id").val('');
        $('#ajax-modal').modal('show');
    }
        function editPost(event) {
            var user_id = $(event).data('id');
            alert(user_id);
            $.get("{{ route('ajax.index') }}" + '/' + user_id + '/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#saveBtn').val("edit-user");
                $('#ajax-modal').modal('show');
                $('#ajax_id').val(data.id);
                $('#firstname').val(data.firstname);
                $('#lastname').val(data.lastname);

            })
        }

        function deletePost(event) {
            var user_id = $(event).data("id");

            $confirm = confirm("Are You sure want to delete !");
            if ($confirm == true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ajax.store') }}" + '/' + user_id,
                    success: function (data) {

                        alert(Object.values(data));

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        }

  $('#saveBtn').click(function (event) {
      event.preventDefault();
      $(this).html('Sending..');
      $.ajax({

          data: $('#ajaxForm').serialize(),
          url: "{{ route('ajax.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#ajaxForm').trigger("reset");
              $('#ajax-modal').modal('hide');

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');

          }

      });


  });


</script>
