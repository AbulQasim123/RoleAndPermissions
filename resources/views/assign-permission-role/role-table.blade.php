@php
    $x = 1;
@endphp
@forelse ($permissionWithRoles as $permission)
    <tr>
        <td>
            {{ $x++ }}
        </td>
        <td>
            {{ $permission->name }}
        </td>
        <td>
            @foreach ($permission->roles as $role)
                {{ $role->name }},
            @endforeach
        </td>
        <td>
            <button type="button" data-bs-toggle="modal" data-bs-target="#updatePermissionRoleModal"
                class="btn btn-outline-primary btn-sm permission_role_edit_btn" data-permissions="{{ $permission->id }}"
                data-roles="{{ $permission->roles }}">
                <span class="bi bi-pencil-square"></span>
            </button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deletePermissionRoleModal"
                class="btn btn-outline-danger btn-sm permission_role_delete_btn"
                data-permissions="{{ $permission->id }}">
                <span class="bi bi-trash-fill"></span>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data found</td>
    </tr>
@endforelse
