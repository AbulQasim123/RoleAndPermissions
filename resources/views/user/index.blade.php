@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <h3>{{ __('Manage Users') }}</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <span class="bi bi-plus-square"> Create User</span>
        </button>

        <div class="table-responsive-lg table-responsive-md table-responsive-sm table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-sm" id="UserTable">
                <thead>
                    <tr>
                        <th class="fw-semibold">#</th>
                        <th class="fw-semibold">Name</th>
                        <th class="fw-semibold">email</th>
                        <th class="fw-semibold">Role</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('user.table', ['users' => $users])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="createUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createUserForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter Username">
                                    <span class="text-danger" id="username_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Email">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password"
                                        placeholder="Enter Password">
                                    <span class="text-danger" id="password_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">User Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="" selected disabled>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="role_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="createUserBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateUserForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="u_username" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="u_username" name="u_username"
                                        placeholder="Enter User">
                                    <span class="text-danger" id="u_username_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="u_email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="u_email" name="u_email"
                                        placeholder="Enter User">
                                    <span class="text-danger" id="u_email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="u_password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="u_password" name="u_password"
                                        placeholder="Enter User">
                                    <span class="text-danger" id="u_password_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="u_role" class="form-label">User Role</label>
                                    <select name="u_role" id="u_role" class="form-select">
                                        <option value="" selected disabled>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="u_role_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="UpdateUserBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteUserForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this <span id="delete_User_name"></span> User?</p>
                        <input type="hidden" name="delete_user_id" id="delete_user_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm" id="deleteUserBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#createUserForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('create-user') }}";
                let formData = new FormData(this);
                $('#createUserForm input, #createUserForm select').on(
                    'input change',
                    function() {
                        let fieldName = $(this).attr('name');
                        clearFieldError(fieldName);
                    });
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#createUserBtn').attr('disabled', true);
                        $('#createUserBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#createUserModal").modal("hide");
                            $("#createUserForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, error) {
                            displayValidationError(field, error[0]);
                        });
                    },
                    complete: function() {
                        $('#createUserBtn').attr('disabled', false);
                        $('#createUserBtn').html('Add');
                    }
                });
            });

            // Edit User
            $('.user_edit_btn').click(function(e) {
                e.preventDefault();
                $('#updateUserModal').modal('show');
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let role = $(this).data('role');
                $('#user_id').val(id);
                $('#u_username').val(name);
                $('#u_email').val(email);
                $('#u_role').val(role);
            });


            // Update User
            $('#updateUserForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('update-user') }}";
                let formData = new FormData(this);
                $('#updateUserForm input').on(
                    'input',
                    function() {
                        let fieldName = $(this).attr('name');
                        clearFieldError(fieldName);
                    });
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#updateUserBtn').attr('disabled', true);
                        $('#updateUserBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#updateUserModal").modal("hide");
                            $("#updateUserForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, error) {
                            displayValidationError(field, error[0]);
                        });
                    },
                    complete: function() {
                        $('#updateUserBtn').attr('disabled', false);
                        $('#updateUserBtn').html('Update');
                    }
                });
            });

            $('.user_delete_btn').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#delete_user_id').val(id);
                $('#deleteUserModal').modal('show');
            });

            // Delete User
            $('#deleteUserForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('delete-user') }}";
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#deleteUserBtn').attr('disabled', true);
                        $('#deleteUserBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#deleteUserModal").modal("hide");
                            $("#deleteUserForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    complete: function() {
                        $('#deleteUserBtn').attr('disabled', false);
                        $('#deleteUserBtn').html('Add');
                    }
                });
            })
        });

        $('#createUserModal').on('hidden.bs.modal', function() {
            $("#username_error").html('');
            $("#email_error").html('');
            $("#password_error").html('');
            $("#role_error").html('');
            $('#createUserForm')[0].reset();
        });

        $('#updateUserModal').on('hidden.bs.modal', function() {
            $("#u_username_error").html('');
            $("#u_email_error").html('');
            $("#u_password_error").html('');
            $("#u_role_error").html('');
        });
        // Display Validation Error
        function displayValidationError(field, error) {
            $('#' + field + '_error').text(error);
        }
        // Clear Validation Error
        function clearFieldError(field) {
            $('#' + field + '_error').text('');
        }
    </script>
@endpush
