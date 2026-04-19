<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <h3>Login</h3>

            <div id="msg"></div>

            <form id="loginForm">

                <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <button class="btn btn-success w-100">Login</button>

            </form>

        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e){
    e.preventDefault();

    let formData = {
        email: this.email.value,
        password: this.password.value
    };

   let res = await fetch('/api/login', {
    method: 'POST',
    credentials: 'omit',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify(formData)
    });
    let data = await res.json();

    if(res.ok){
        document.getElementById('msg').innerHTML =
            `<div class="alert alert-success">Login Successful</div>`;
        localStorage.setItem('token', data.token);
    } else {
        document.getElementById('msg').innerHTML =
            `<div class="alert alert-danger">${data.message}</div>`;
    }
});
</script>

</body>
</html>