@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">User Management</h4>
        <div>
            <a href="{{ route('users.export') }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add User
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex gap-2 align-items-center">
            <select name="status" class="form-select w-auto">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            
            @if(request('status'))
                <a href="{{ route('users.index') }}" class="text-decoration-none text-muted small">Clear Filter</a>
            @endif
        </form>

        <form method="POST" action="{{ route('users.bulk_delete') }}">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="40"><input type="checkbox" id="select-all" class="form-check-input"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse handles the loop AND the empty state automatically --}}
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="form-check-input">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                {{-- Your colorful badge logic is perfect here --}}
                                <span class="badge rounded-pill bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm text-white" title="Edit">
                                    Edit
                                </a>
                                
                                <button type="button" class="btn btn-danger btn-sm" 
                                        onclick="if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-{{ $user->id }}').submit(); }">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        {{-- This row only shows if there are NO users --}}
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <h5>No users found</h5>
                                <p class="mb-0">Try adjusting your filters or add a new user.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Only show Bulk Delete button if there are actually users --}}
            @if($users->count() > 0)
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete the selected users?')">
                    Bulk Delete Selected
                </button>
            @endif
            
            <div class="mt-3">
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </form>

        {{-- Hidden Delete Forms (Keep this exactly as you had it) --}}
        @foreach($users as $user)
            <form id="delete-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                @csrf @method('DELETE')
            </form>
        @endforeach

    </div>
</div>

<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
@endsection