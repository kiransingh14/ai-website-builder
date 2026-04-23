<!DOCTYPE html>

<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

        <h3>Login</h3>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <input 
                type="email" 
                name="email" 
                class="form-control mb-2" 
                placeholder="Email" 
                required
            >

            <input 
                type="password" 
                name="password" 
                class="form-control mb-2" 
                placeholder="Password" 
                required
            >

            <button class="btn btn-success w-100">
                Login
            </button>
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
