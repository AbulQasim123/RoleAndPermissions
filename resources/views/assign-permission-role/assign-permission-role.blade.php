@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <h3>{{ __('Manage Roles') }}</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#permissionRoleModal">
            <span class="bi bi-plus-square"> Assign P & R</span>
        </button>

        <div class="table-responsive-lg table-responsive-md table-responsive-sm table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-sm" id="PermissionRoleTable">
                <thead>
                    <tr>
                        <th class="fw-semibold">#</th>
                        <th class="fw-semibold">Permission</th>
                        <th class="fw-semibold">Roles</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('assign-permission-role.role-table', [
                        'roles' => $roles,
                        'permissions' => $permissions,
                    ])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="permissionRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="permissionRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Assign Permissions Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permissions" class="form-label">Permissions</label>
                            <select name="permissions" class="form-control" id="permissions">
                                <option value="" selected disabled>Select Permissions</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="permissions_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select name="roles" class="form-control" id="roles">
                                <option value="" selected disabled>Select Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="roles_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm"
                            id="assignPermissionRoleBtn">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updatePermissionRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updatePermissionRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Permissions Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="update_permissions" class="form-label">Permissions</label>
                            <select name="update_permissions" class="form-control" id="update_permissions" style="pointer-events: none">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="update_permissions_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Roles</label>
                            <div class="multi-select-dropdown">
                                <div class="select-box">
                                    <input type="text" id="selected-options-name" placeholder="Select Options" readonly>
                                    <input type="hidden" id="selected-options" name="roles">
                                    <div class="arrow">&#9660;</div>
                                    <div class="options-container" id="options-container">
                                        @foreach ($roles as $role)
                                            <label for="" class="option">
                                                <input type="checkbox" data-name="{{ $role->name }}"
                                                    value="{{ $role->id }}"> {{ $role->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <span class="text-danger" id="update_role_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            id="updateAssignPermissionRoleBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePermissionRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deletePermissionRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Permission Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this permissions & role?</p>
                        <input type="hidden" name="delete_permission_role_id" id="delete_permission_role_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm" id="deletePermissionRoleBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#permissionRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('create-permission-role') }}";
                let formData = new FormData(this);
                $('#permissionRoleForm input, #permissionRoleForm select').on(
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
                        $('#assignPermissionRoleBtn').attr('disabled', true);
                        $('#assignPermissionRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#permissionRoleModal").modal("hide");
                            $("#permissionRoleForm")[0].reset();
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
                        $('#assignPermissionRoleBtn').attr('disabled', false);
                        $('#assignPermissionRoleBtn').html('Add');
                    }
                });
            });

            // Edit Permission & Role
            $('.permission_role_edit_btn').click(function(e) {
                $('#options-container input').prop('checked', false);
                let permissionId = $(this).data('permissions');
                $('#update_permissions').val(permissionId);
                let roles = $(this).data('roles');

                if (roles.length > 0) {
                    for (let x = 0; x < roles.length; x++) {
                        $("#options-container input[value='" + roles[x]['id'] + "']").prop('checked', true);
                    }
                }
                updateSelectedOptions();
            });

            // Update Permission Role
            $('#updatePermissionRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('update-permission-role') }}";
                let formData = new FormData(this);
                if($('#selected-options').val() == ''){
                    alert("Pleasae Select atleast One Role");
                    return false;
                }
                $('#updatePermissionRoleForm input, #updatePermissionRoleForm select').on(
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
                        $('#updateAssignPermissionRoleBtn').attr('disabled', true);
                        $('#updateAssignPermissionRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#updatePermissionRoleModal").modal("hide");
                            $("#updatePermissionRoleForm")[0].reset();
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
                        $('#updateAssignPermissionRoleBtn').attr('disabled', false);
                        $('#updateAssignPermissionRoleBtn').html('Update');
                    }
                });
            });

            $('.permission_role_delete_btn').click(function(e) {
                e.preventDefault();
                let id = $(this).data('permissions');
                $('#delete_permission_role_id').val(id);
            });

            // Delete Role
            $('#deletePermissionRoleForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('delete-permission-role') }}";
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#deletePermissionRoleBtn').attr('disabled', true);
                        $('#deletePermissionRoleBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#deletePermissionRoleModal").modal("hide");
                            $("#deletePermissionRoleForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    complete: function() {
                        $('#deletePermissionRoleBtn').attr('disabled', false);
                        $('#deletePermissionRoleBtn').html('Add');
                    }
                });
            })

            function updateSelectedOptions() {
                let selectedOptions = [];
                let selectedOptionsName = [];
                // Function to update selected options display
                $('.options-container .option input:checked').each(function() {
                    selectedOptions.push($(this).val());
                    selectedOptionsName.push($(this).data('name'));
                });
                $('#selected-options').val(selectedOptions.join(', '));
                $('#selected-options-name').val(selectedOptionsName.join(', '));
            }

            // Toggle dropdown visibility
            $(".select-box").click(function() {
                $("#options-container").toggle();
            })

            // Hide dropdown is checking outside of it
            $(document).click(function(event) {
                if (!$(event.target).closest('.multi-select-dropdown').length) {
                    $("#options-container").hide();
                }
            })

            // Update selcted options when a checkbox is checked
            $(".options-container .option input").change(function() {
                updateSelectedOptions();
            });


        });

        $('#permissionRoleModal').on('hidden.bs.modal', function() {
            $("#roles_error").html('');
            $("#permissions_error").html('');
            $('#permissionRoleForm')[0].reset();
        });

        $('#updatePermissionRoleModal').on('hidden.bs.modal', function() {
            $("#update_permissions_error").html('');
            $("#update_role_error").html('');
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
