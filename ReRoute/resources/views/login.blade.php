<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .error{
            color:red;
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            {{$error ? 'display: block;' : 'display: none;'}}
        }
    </style>
</head>

<body>

    <div id="container">
        <div class="popup" id="popup" style="display: flex;">
            <div style="width: 80%;display:flex;gap:25px;flex-direction:column">
            <input type="text" id="name_field" class="text" placeholder="Name">

            <input type="password" id="password_field" class="text" placeholder="Password">
            <div class="error">Error logging in</div>
            <button class="button" onclick="login()">
                login
            </button>
            </div>

        </div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>
