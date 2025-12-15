@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>User Management</h4>
        <div>
            <a href="{{ route('users.export') }}" class="btn btn-success btn-sm">Export Excel</a>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add User</a>
        </div>
    </div>
    <div class="card-body">
        
        <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex gap-2">
            <select name="status" class="form-select w-auto">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        </form>

        <form method="POST" action="{{ route('users.bulk_delete') }}">
            @csrf
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $user->id }}"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm text-white">Edit</a>
                            
                            <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="if(confirm('Are you sure?')) { document.getElementById('delete-{{ $user->id }}').submit(); }">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected?')">Bulk Delete Selected</button>
            
            <div class="mt-3">
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </form>

        @foreach($users as $user)
            <form id="delete-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                @csrf @method('DELETE')
            </form>
        @endforeach

    </div>
</div>

<script>
    // Simple script to handle "Select All" checkbox
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
@endsection