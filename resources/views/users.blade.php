
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            color: #1e40af;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 10px 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .edit-btn {
            background: #0891b2;
        }

        .delete-btn {
            background: #dc2626;
        }

        .cancel-btn {
            background: #64748b;
            display: inline-block;
            padding: 10px 18px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #2563eb;
            color: white;
        }

        .success {
            color: green;
            margin: 15px 0;
        }

        .error {
            color: red;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 6px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Users Management</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($editingUser))

        <h2>Update User</h2>

        <form action="/users/update" method="POST">
            @csrf

            <input type="hidden" name="id"
                   value="{{ $editingUser->id }}">

            <input type="text" name="name"
                   value="{{ old('name', $editingUser->name) }}"
                   placeholder="User Name" required>

            <input type="email" name="email"
                   value="{{ old('email', $editingUser->email) }}"
                   placeholder="User Email" required>

            <input type="password" name="password"
                   placeholder="New Password (optional)">

            <button type="submit">Update User</button>

            <a href="/users" class="cancel-btn">Cancel</a>
        </form>

    @else

        <h2>Add New User</h2>

        <form action="/users" method="POST">
            @csrf

            <input type="text" name="name"
                   value="{{ old('name') }}"
                   placeholder="User Name" required>

            <input type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="User Email" required>

            <input type="password" name="password"
                   placeholder="User Password" required>

            <button type="submit">Add User</button>
        </form>

    @endif

    <h2>Users List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        @foreach($users as $user)

        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
                <div class="actions">

                    <form action="/users/edit/{{ $user->id }}"
                          method="POST">
                        @csrf

                        <button type="submit" class="edit-btn">
                            Edit
                        </button>
                    </form>

                    <form action="/users/delete/{{ $user->id }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this user?')">

                        @csrf

                        <button type="submit" class="delete-btn">
                            Delete
                        </button>
                    </form>

                </div>
            </td>
        </tr>

        @endforeach

    </table>

</div>

</body>
</html>
