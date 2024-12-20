<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Users Management</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>

    <body>
        <div class="container my-5">
            <h2 class="text-center mb-4">Users Management</h2>

            {{-- Test Spatie Laravel Permission package that if permissions can be used as Gates and Policies --}}
            {{-- @can('create projects')
                <p style="font-weight: bold">hey</p>
            @endcan --}}

            <!-- Success and Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @error('error')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror

            <!-- Go Back to Dashboard Button -->
            <div class="mb-4 text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Go back to Dashboard
                </a>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Users</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Current Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->roles->isEmpty())
                                            <span class="badge bg-secondary">No Role</span>
                                        @else
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info">{{ $role->name }}</span>
                                            @endforeach
                                        @endif

                                    {{-- Debugging --}}
                                    {{-- @dd(Auth::user()->can('edit roles')) --}}

                                    <td>
                                        <!-- Edit Role Button -->
                                        <button class="btn btn-primary btn-sm edit-role-btn"
                                                data-id="{{ $user->id }}"
                                                {{-- @if(!auth()->user()->hasRole('admin')) disabled @endif --}}
                                                @cannot('edit roles') disabled @endcannot {{-- Disable Edit Role if the authenticated user does not have the 'edit roles' permission (i.e. is not an 'admin' or 'supervisor') --}}
                                                {{ Auth::user()->hasRole('admin') && Auth::user()->id == $user->id ? 'disabled' : '' }} {{-- Disable Edit Role if the authenticated user has an 'admin' role and is editing their own role in order to prevent them from getting locked out --}}
                                        >
                                            <i class="fa fa-edit"></i> Edit Role
                                        </button>

                                        <!-- Delete Role Button -->
                                        <button class="btn btn-danger btn-sm delete-role-btn"
                                                data-id="{{ $user->id }}"
                                                @if(!auth()->user()->hasRole('admin')) disabled @endif {{-- Disable Delete Role if the authenticated user does not have the 'admin' role --}}
                                                {{ Auth::user()->hasRole('admin') && Auth::user()->id == $user->id ? 'disabled' : '' }} {{-- Disable Delete Role if the authenticated user has an 'admin' role and is editing their own role in order to prevent them from getting locked out --}}
                                        >
                                            <i class="fa fa-trash"></i> Delete Role
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Restricted Alert Modal -->
        <div class="modal fade" id="restrictedModal" tabindex="-1" aria-labelledby="restrictedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restrictedModalLabel">Access Denied</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Restricted to "admin" only.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function () {
                // Handle Edit Role Button Click
                $('.edit-role-btn').on('click', function () {
                    const userId = $(this).data('id');

                    @if(Auth::user()->can('edit roles'))
                        // Redirect to the edit role page (you can modify the route here)
                        window.location.href = `/dashboard/users/${userId}/edit-role`;
                    @else
                        // Show the restricted access modal
                        $('#restrictedModal').modal('show');
                    @endif
                });

                // Handle Delete Role Button Click
                $('.delete-role-btn').on('click', function () {
                    const userId = $(this).data('id');
                    console.log(userId);

                    @if(auth()->user()->hasRole('admin'))
                        // Perform the delete action (AJAX or redirect to backend route)
                        if (confirm('Are you sure you want to delete this user\'s roles?')) {
                            $.ajax({
                                url: `/dashboard/users/${userId}/delete-role`,
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    alert(response.message || 'Role deleted successfully.');
                                    location.reload();
                                },
                                error: function () {
                                    alert('Failed to delete the role.');
                                }
                            });
                        }
                    @else
                        // Show the restricted access modal
                        $('#restrictedModal').modal('show');
                    @endif
                });
            });
        </script>
    </body>

</html>
