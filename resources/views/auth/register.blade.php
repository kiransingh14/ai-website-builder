<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <h3>Register</h3>

            <div id="msg"></div>

            <form id="registerForm">

                <input type="text" name="name" class="form-control mb-2" placeholder="Name">
                <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <button class="btn btn-primary w-100">Register</button>

            </form>

        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e){
    e.preventDefault();

    let formData = {
        name: this.name.value,
        email: this.email.value,
        password: this.password.value
    };

    let res = await fetch('/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    });

    let data = await res.json();

    if(res.ok){
        document.getElementById('msg').innerHTML =
            `<div class="alert alert-success">Registered Successfully</div>`;
        localStorage.setItem('token', data.token);
    } else {
        document.getElementById('msg').innerHTML =
            `<div class="alert alert-danger">${data.message || 'Error'}</div>`;
    }
});
</script>

</body>
</html>