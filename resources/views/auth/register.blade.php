<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <h3>Register</h3>

            <div id="msg"></div>

            <form id="registerForm" method="POST"  action="/register">
            @csrf
                <input type="text" name="name" class="form-control mb-2" placeholder="Name">
                <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <button class="btn btn-primary w-100">Register</button>

            </form>

        </div>
    </div>
</div>
<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right"
};
</script>

{{-- Success --}}
@if(session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

{{-- Error --}}
@if(session('error'))
<script>
    toastr.error("{{ session('error') }}");
</script>
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        <script>
            toastr.error("{{ $error }}");
        </script>
    @endforeach
@endif
</body>
</html>