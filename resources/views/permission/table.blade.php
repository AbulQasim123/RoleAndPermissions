@php
    $x = 1;
@endphp
@forelse ($permissions as $permission)
    <tr>
        <td>
            {{ $x++ }}
        </td>
        <td>
            {{ $permission->name }}
        </td>
        <td>
            <button type="button" class="btn btn-outline-primary btn-sm permission_edit_btn"
                data-name="{{ $permission->name }}" data-id="{{ $permission->id }}">
                <span class="bi bi-pencil-square"></span>
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm permission_delete_btn"
                data-name="{{ $permission->name }}" data-id="{{ $permission->id }}"><span
                    class="bi bi-trash-fill"></span></button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data found</td>
    </tr>
@endforelse
