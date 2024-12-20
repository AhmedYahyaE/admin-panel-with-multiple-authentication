{{-- resources/views/dashboard/users/edit-role.blade.php --}}
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User Role</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <h2>Edit Role for User: {{ $user->name }}</h2>

            {{-- Display any session messages --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @error('role')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror



            {{-- Debugging --}}
            {{-- @dd($user->hasRole('admin')) --}}
            {{-- @dd($user->hasRole('supervisor')) --}}
            {{-- @dd($user->hasRole('regular user')) --}}
            {{-- @dd(Auth::user()->hasRole('admin') && Auth::user()->id == $user->id) --}}



            {{-- Form to edit role --}}
            <form action="{{ route('dashboard.users.edit-role', $user->id) }}" method="POST">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                        <option value="supervisor" {{ $user->hasRole('supervisor') ? 'selected' : '' }}>Supervisor</option>
                        <option value="regular user" {{ $user->hasRole('regular user') ? 'selected' : '' }}>Regular User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>

            {{-- Back Button --}}
            <a href="{{ route('dashboard.users') }}" class="btn btn-secondary mt-3">Back to Users</a>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
