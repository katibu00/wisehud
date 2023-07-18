<table class="table">
    <thead>
        <tr>
            <th>S/N</th>
            <th> Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
           
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
              
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle"
                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                            <a class="dropdown-item change-password" href="#" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Change Password</a>
                         
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item deleteItem" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Delete User</button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
