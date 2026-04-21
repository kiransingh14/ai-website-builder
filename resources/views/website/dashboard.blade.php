<!DOCTYPE html>

<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<!-- CENTER -->
    <div class="text-center flex-grow-1">
        <h3 class="mb-0">My Businesses</h3>
    </div>

<!-- TOP BAR -->
<div class="d-flex align-items-center justify-content-between mb-4">

    <!-- LEFT -->
    <div>
        <a href="/addBusinessDetails" class="btn btn-primary">
            + Add Business
        </a>
    </div>

    <!-- RIGHT -->
    <div>
        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>

</div>

<!-- TABLE -->
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
                <td colspan="4" class="text-center">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- BOTTOM RIGHT CONTROLS -->
<div class="d-flex justify-content-end align-items-center gap-3 mt-3">

    <!-- PAGE SIZE -->
    <form method="GET">
        <select name="per_page" onchange="this.form.submit()" class="form-select w-auto">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>

    <!-- PAGINATION -->
    <div>
        {{ $businesses->links() }}
    </div>

</div>

</div>

</body>
</html>
