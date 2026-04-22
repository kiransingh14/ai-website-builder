<!DOCTYPE html>
<html>
<head>
    <title>Add Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <h3>Add Business</h3>

            <div id="msg"></div>

            <form id="registerForm" method="POST"  action="/addBusinessDetails">
            @csrf
                <input type="text" name="name" class="form-control mb-2" placeholder="Name">
                <input type="text" name="type" class="form-control mb-2" placeholder="Type">
                <input type="text" name="description" class="form-control mb-2" placeholder="Description">

                <button class="btn btn-primary w-100">Add</button>

            </form>

        </div>
    </div>
</div>

</body>
</html>