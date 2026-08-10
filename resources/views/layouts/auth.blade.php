<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Login POS')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      body{
    background:linear-gradient(135deg,#ff4d94,#ffc1d9);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Segoe UI',sans-serif;
}

.btn-login{
    width:100%;
    height:50px;
    background:#ff4d94;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:18px;
    font-weight:bold;
    transition:0.3s;
}
        .login-card{
            width:420px;
            background:#ffffff;
            padding:35px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,.2);
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>