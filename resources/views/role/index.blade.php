@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <h3>{{ __('Manage Roles') }}</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <span class="bi bi-plus-square"> Create Role</span>
        </button>

        <div class="table-responsive-lg table-responsive-md table-responsive-sm table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-sm" id="RoleTable">
                <thead>
                    <tr>
                        <th class="fw-semibold">#</th>
                        <th class="fw-semibold">Role</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('role.table', ['roles' => $roles])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="createRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Create Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" name="role"
                                placeholder="Enter role">
                            <span class="text-danger" id="role_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="createRoleBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateRoleForm">
                    @csrf
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="edit_role" name="edit_role"
                                placeholder="Enter role">
                            <span class="text-danger" id="edit_role_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="updateRoleBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this <span id="delete_role_name"></span> role?</p>
                        <input type="hidden" name="delete_role_id" id="delete_role_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm" id="deleteRoleBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#createRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('create.role') }}";
                let formData = new FormData(this);
                $('#createRoleForm input').on(
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
                        $('#createRoleBtn').attr('disabled', true);
                        $('#createRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#createRoleModal").modal("hide");
                            $("#createRoleForm")[0].reset();
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
                        $('#createRoleBtn').attr('disabled', false);
                        $('#createRoleBtn').html('Add');
                    }
                });
            });

            // Edit Employee
            $('.role_edit_btn').click(function(e) {
                e.preventDefault();
                $('#updateRoleModal').modal('show');
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#edit_role').val(name);
                $('#role_id').val(id);
            });


            // Update Employee
            $('#updateRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('update.role') }}";
                let formData = new FormData(this);
                $('#updateRoleForm input').on(
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
                        $('#updateRoleBtn').attr('disabled', true);
                        $('#updateRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#updateRoleModal").modal("hide");
                            $("#updateRoleForm")[0].reset();
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
                        $('#updateRoleBtn').attr('disabled', false);
                        $('#updateRoleBtn').html('Update');
                    }
                });
            });

            $('.role_delete_btn').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#delete_role_name').text(name);
                $('#delete_role_id').val(id);
                $('#deleteRoleModal').modal('show');
            });

            // Delete Employee
            $('#deleteRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('delete.role') }}";
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#deleteRoleBtn').attr('disabled', true);
                        $('#deleteRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#deleteRoleModal").modal("hide");
                            $("#deleteRoleForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    complete: function() {
                        $('#deleteRoleBtn').attr('disabled', false);
                        $('#deleteRoleBtn').html('Add');
                    }
                });
            })
        });

        $('#createRoleModal').on('hidden.bs.modal', function() {
            $("#role_error").html('');
            $('#createRoleForm')[0].reset();
        });

        $('#createRoleModal').on('hidden.bs.modal', function() {
            $("#edit_role_error").html('');
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
