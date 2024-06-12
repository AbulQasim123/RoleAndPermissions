@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <h3>{{ __('Manage Roles') }}</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#permissionRouteModal">
            <span class="bi bi-plus-square"> Assign Permissions Route</span>
        </button>

        <div class="table-responsive-lg table-responsive-md table-responsive-sm table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-sm" id="PermissionRouteTable">
                <thead>
                    <tr>
                        <th class="fw-semibold">#</th>
                        <th class="fw-semibold">Permission</th>
                        <th class="fw-semibold">RouteName</th>
                        <th class="fw-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('assign-permission-role.route-table', [
                        'permissionRoutes' => $permissionRoutes,
                    ])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal Route-->
    <div class="modal fade" id="permissionRouteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="permissionRouteForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Assign Permissions Route</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permissions_id" class="form-label">Permissions</label>
                            <select name="permissions_id" class="form-control" id="permissions_id">
                                <option value="" selected disabled>Select Permissions</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="permissions_id_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="routes" class="form-label">Roles</label>
                            <select name="routes" class="form-control" id="routes">
                                <option value="" selected disabled>Select Routes</option>
                                @foreach ($routeDetails as $routeDetail)
                                    <option value="{{ $routeDetail['name'] }}">{{ $routeDetail['name'] }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="routes_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm"
                            id="assignPermissionRouteBtn">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal Route-->
    <div class="modal fade" id="updatePermissionRouteModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updatePermissionRouteForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Permissions Route</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="update_id" id="update_id">
                            <label for="update_permissions_id" class="form-label">Permissions</label>
                            <select name="update_permissions_id" class="form-control" id="update_permissions_id">
                                <option value="" selected disabled>Select Permissions</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="update_permissions_id_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="update_routes" class="form-label">Roles</label>
                            <select name="update_routes" class="form-control" id="update_routes">
                                <option value="" selected disabled>Select Routes</option>
                                @foreach ($routeDetails as $routeDetail)
                                    <option value="{{ $routeDetail['name'] }}">{{ $routeDetail['name'] }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="update_routes_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm"
                            id="updatePermissionRouteBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePermissionRouteModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deletePermissionRouteForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Permission Route</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this permissions & Route?</p>
                        <input type="hidden" name="delete_router_id" id="delete_router_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm"
                            id="deletePermissionRouteBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#permissionRouteForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('create-permission-route') }}";
                let formData = new FormData(this);
                $('#permissionRouteForm input, #permissionRouteForm select').on(
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
                        $('#assignPermissionRouteBtn').attr('disabled', true);
                        $('#assignPermissionRouteBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#permissionRouteModal").modal("hide");
                            $("#permissionRouteForm")[0].reset();
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
                        $('#assignPermissionRouteBtn').attr('disabled', false);
                        $('#assignPermissionRouteBtn').html('Assign');
                    }
                });
            });

            // update route
            $('.permission_route_edit_btn').click(function(e) {
                e.preventDefault();
                let route_id = $(this).data('id');
                let permissions_id = $(this).data('permission-id');
                let route = $(this).data('route');

                $('#update_id').val(route_id);
                $('#update_permissions_id').val(permissions_id);
                $('#update_routes').val(route);
            });

            // Update Permission
            $('#updatePermissionRouteForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('update-permission-route') }}";
                let formData = new FormData(this);
                $('#updatePermissionRouteForm input, #updatePermissionRouteForm select').on(
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
                        $('#updatePermissionRouteBtn').attr('disabled', true);
                        $('#updatePermissionRouteBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#updatePermissionRouteModal").modal("hide");
                            $("#updatePermissionRouteForm")[0].reset();
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
                        $('#updatePermissionRouteBtn').attr('disabled', false);
                        $('#updatePermissionRouteBtn').html('Update');
                    }
                });
            });

            $('.permission_route_delete_btn').click(function(e) {
                e.preventDefault();
                let route_id = $(this).data('id');
                $('#delete_router_id').val(route_id);
            });

            // Delete Employee
            $('#deletePermissionRouteForm').submit(function(e) {
                e.preventDefault();
                let action_url = "{{ route('delete-permission-route') }}";
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#deletePermissionRouteBtn').attr('disabled', true);
                        $('#deletePermissionRouteBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#deletePermissionRouteModal").modal("hide");
                            $("#deletePermissionRouteForm")[0].reset();
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                    },
                    complete: function() {
                        $('#deletePermissionRouteBtn').attr('disabled', false);
                        $('#deletePermissionRouteBtn').html('Add');
                    }
                });
            })
        });


        $('#permissionRouteModal').on('hidden.bs.modal', function() {
            $("#permissions_id_error").html('');
            $("#routes_error").html('');
            $('#permissionRouteModal')[0].reset();
        });

        $('#updatePermissionRouteModal').on('hidden.bs.modal', function() {
            $("#update_permissions_id_error").html('');
            $("#update_routes_error").html('');
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
