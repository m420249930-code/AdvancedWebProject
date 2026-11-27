<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
        }

        input {
            padding: 9px;
            margin: 5px;
        }

        button {
            padding: 8px 14px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .edit {
            background: #198754;
            color: white;
        }

        .delete {
            background: #dc3545;
            color: white;
        }

        .update {
            background: #0d6efd;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Tasks Management</h2>

    {{-- رسالة النجاح --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    {{-- رسائل الأخطاء --}}
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    {{-- فورم التعديل --}}
    @isset($editingTask)

        <h3>Edit Task</h3>

        <form action="/tasks/update" method="POST">
            @csrf

            <input type="hidden" name="id"
                   value="{{ $editingTask->id }}">

            <input type="text" name="name"
                   value="{{ $editingTask->name }}"
                   required>

            <button type="submit" class="update">
                Update Task
            </button>
        </form>

        <hr>

    @endisset

    {{-- عرض المهام --}}
    <h3>All Tasks</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            @forelse($tasks as $task)

                <tr>
                    <td>{{ $task->id }}</td>

                    <td>{{ $task->name }}</td>

                    <td>
                        <form action="/tasks/edit/{{ $task->id }}"
                              method="POST">
                            @csrf

                            <button type="submit" class="edit">
                                Edit
                            </button>
                        </form>
                    </td>

                    <td>
                        <form action="/tasks/delete/{{ $task->id }}"
                              method="POST">
                            @csrf

                            <button type="submit" class="delete"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">No Tasks Found</td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

</body>
</html>
