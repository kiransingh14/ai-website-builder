<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between">
    <h3>My Businesses</h3>
        <form method="POST" action="/business">
        @csrf
            <button class="btn btn-danger">Add Business</button>
        </form>

        <form method="POST" action="/logout">
        @csrf
        <button class="btn btn-danger">Logout</button>
        </form> 

        </div>

    <form method="GET" class="my-3">
        <select name="per_page" onchange="this.form.submit()" class="form-select w-auto">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
            </tr>
        </thead>

        <tbody>
            @forelse($businesses as $business)
                <tr>
                    <td>{{ $business->id }}</td>
                    <td>{{ $business->name }}</td>
                    <td>{{ $business->type }}</td>
                    <td>{{ $business->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $businesses->links() }}

</div>

</body>
</html>