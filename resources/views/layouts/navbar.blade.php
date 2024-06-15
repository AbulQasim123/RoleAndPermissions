<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('auth.dashboard') }}">Hi {{ Auth::user()->name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('manage-user') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('manage-role') }}">Manage Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('manage-permission') }}">Manage
                        Permission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="{{ route('assign-permission-role') }}">Assing-Permission-Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="{{ route('assign-permission-route') }}">Assing-Permission-Route</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="logout-user" href="{{ route('auth.logout') }}">Logout</a>
                </li>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#logout-user').click(function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to logout?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('auth.logout') }}",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == true) {
                                location.reload();
                            } else {
                                alert(response.data);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
