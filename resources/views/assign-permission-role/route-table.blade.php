@php
    $x = 1;
@endphp
@forelse ($permissionRoutes as $permissionRoute)
    <tr>
        <td>{{ $x++ }}</td>
        <td>{{ $permissionRoute->permission->name }}</td>
        <td>{{ $permissionRoute->router }}</td>
        <td>
            <button type="button" data-bs-toggle="modal" data-bs-target="#updatePermissionRouteModal"
                class="btn btn-outline-primary btn-sm permission_route_edit_btn" data-id="{{ $permissionRoute->id }}"
                data-permission-id="{{ $permissionRoute->permission_id }}" data-route="{{ $permissionRoute->router }}">
                <span class="bi bi-pencil-square"></span>
            </button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deletePermissionRouteModal"
                class="btn btn-outline-danger btn-sm permission_route_delete_btn" data-id="{{ $permissionRoute->id }}">
                <span class="bi bi-trash-fill"></span>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data found</td>
    </tr>
@endforelse
