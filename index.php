<?php 
include 'master/config.php';
?>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container" style="max-width: 475px; max-height: 500px; min-width: 400px; min-height: 350px;">
        <div class="card p-4">
            <b><div class="card-header text-center">
            Company Name
            </div></b>
            <div class="card-body">
                <form action="master/login.php" method="post">
                    <div>
                        <b><label class="form-label mt-3">Employee code:</label></b>
                        <input type="text" name="username" placeholder="Username" class="form-control mt-3" reqired>
                    </div>
                    <div>
                        <b><label class="form-label mt-3">Password:</label></b>
                        <input type="password" name="password" placeholder="Password" class="form-control mt-3" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark mt-5">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
