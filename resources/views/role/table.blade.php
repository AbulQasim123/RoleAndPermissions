@php
    $x = 1;
@endphp
@foreach ($roles as $role)
    <tr>
        <td>
            {{ $x++ }}
        </td>
        <td>
            {{ $role->name }}
        </td>
        <td>
            <button type="button" class="btn btn-outline-primary btn-sm role_edit_btn" data-name="{{ $role->name }}" data-id="{{ $role->id }}">
                <span class="bi bi-pencil-square"></span>
            </button>
            <button type="button"
                class="btn btn-outline-danger btn-sm role_delete_btn" data-name="{{ $role->name }}"
                data-id="{{ $role->id }}"><span class="bi bi-trash-fill"></span></button>
        </td>
    </tr>
@endforeach
