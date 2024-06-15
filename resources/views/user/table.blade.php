@php
    $x = 1;
@endphp
@forelse($users as $user)
    <tr>
        <td>
            {{ $x++ }}
        </td>
        <td>
            {{ $user->name }}
        </td>
        <td>
            {{ $user->email }}
        </td>
        <td>
            {{ $user->role->name }}
        </td>
        <td>
            <button type="button" class="btn btn-outline-primary btn-sm user_edit_btn" data-id="{{ $user->id }}"
                data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role_id }}">
                <span class="bi bi-pencil-square"></span>
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm user_delete_btn" data-id="{{ $user->id }}">
                <span class="bi bi-trash-fill"></span>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data found</td>
    </tr>
@endforelse
