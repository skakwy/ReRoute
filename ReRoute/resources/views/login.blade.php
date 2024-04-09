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
            <input type="text" id="name_field" class="text" placeholder="Name">

            <input type="text" id="password_field" class="text" placeholder="Password">
            <div class="error">Error logging in</div>
            <button class="button" onclick="login()">
                login
            </button>

        </div>
    </div>
    <script>
        function login() {
            var name = document.getElementById('name_field').value;
            var password = document.getElementById('password_field').value;
            window.location.href = "/login/" + name + "/" + password;
        }
    </script>
</body>

</html>
