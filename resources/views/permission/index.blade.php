@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <h3>{{ __('Manage permissions') }}</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#createPermissionModal">
            <span class="bi bi-plus-square"> Create Permission</span>
        </button>

        <div class="table-responsive-lg table-responsive-md table-responsive-sm table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-sm" id="permissionTable">
                <thead>
                    <tr>
                        <th class="fw-semibold">#</th>
                        <th class="fw-semibold">Permission</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('permission.table', ['permissions' => $permissions])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="createPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createPermissionForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Create Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permission" class="form-label">Permission</label>
                            <input type="text" class="form-control" id="permission" name="permission"
                                placeholder="Enter permission">
                            <span class="text-danger" id="permission_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="createPermissionBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updatePermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updatePermissionForm">
                    @csrf
                    <input type="hidden" name="permission_id" id="permission_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_Permission" class="form-label">Permission</label>
                            <input type="text" class="form-control" id="edit_permission" name="edit_permission"
                                placeholder="Enter permission">
                            <span class="text-danger" id="edit_permission_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="updatePermissionBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deletePermissionForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this <span id="delete_permission_name"></span> Permission?</p>
                        <input type="hidden" name="delete_permission_id" id="delete_permission_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm"
                            id="deletePermissionBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#createPermissionForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('create.permission') }}";
                let formData = new FormData(this);
                $('#createPermissionForm input').on(
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
                        $('#createPermissionBtn').attr('disabled', true);
                        $('#createPermissionBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#createPermissionModal").modal("hide");
                            $("#createPermissionForm")[0].reset();
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
                        $('#createPermissionBtn').attr('disabled', false);
                        $('#createPermissionBtn').html('Add');
                    }
                });
            });

            // Edit Employee
            $('.permission_edit_btn').click(function(e) {
                e.preventDefault();
                $('#updatePermissionModal').modal('show');
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#edit_permission').val(name);
                $('#permission_id').val(id);
            });


            // Update Employee
            $('#updatePermissionForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('update.permission') }}";
                let formData = new FormData(this);
                $('#updatePermissionForm input').on(
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
                        $('#updatePermissionBtn').attr('disabled', true);
                        $('#updatePermissionBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#updatePermissionModal").modal("hide");
                            $("#updatePermissionForm")[0].reset();
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
                        $('#updatePermissionBtn').attr('disabled', false);
                        $('#updatePermissionBtn').html('Update');
                    }
                });
            });

            $('.permission_delete_btn').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#delete_permission_name').text(name);
                $('#delete_permission_id').val(id);
                $('#deletePermissionModal').modal('show');
            });

            // Delete Employee
            $('#deletePermissionForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('delete.permission') }}";
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#deletePermissionBtn').attr('disabled', true);
                        $('#deletePermissionBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#deletePermissionModal").modal("hide");
                            $("#deletePermissionForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    complete: function() {
                        $('#deletePermissionBtn').attr('disabled', false);
                        $('#deletePermissionBtn').html('Add');
                    }
                });
            })
        });

        $('#createPermissionModal').on('hidden.bs.modal', function() {
            $("#permission_error").html('');
            $('#createPermissionForm')[0].reset();
        });

        $('#createPermissionModal').on('hidden.bs.modal', function() {
            $("#edit_permission_error").html('');
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
