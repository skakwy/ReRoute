<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReRoute</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="container">

        @foreach ($services as $service)
            <div class="reItem">
                <a style="color: white;text-decoration: none"
                    onclick="window.location.href = '{{ $service->isHttps == true ? 'https:/\/' : 'http:/\/' }}{{ $service->url }}'">{{ $service->name }}</a>
            </div>
        @endforeach
        <div class="reItem" id="addButton" style="background-color: transparent;">
            Add
        </div>

        {{-- popup --}}
        <div class="popup" id="popup">
            <div style="width: 70%;display:flex;flex-direction:column;gap:25px">
                <input type="text" id="name_field" class="text" placeholder="Name">

                <input type="text" id="url_field" class="text" placeholder="URL">
                <div class="checkBox">
                    <input type="checkbox" id="https_field">
                    Uses Https
                </div>
                <button class="button" onclick="addService()">
                    Add
                </button>

                <button class="cancel_button" onclick="closePopup()" id="operation_btn">
                    cancel
                </button>
            </div>
        </div>
    </div>
    <script>
        let popup = document.getElementById("popup");
        var popupOpen = false;


        document.getElementById("addButton").addEventListener("click", () => {
            showPopup();
        })

        function showPopup(name = null, url = null) {
            popupOpen = true;
            if (name != null && url != null) {
                document.getElementById("name_field").value = name;
                document.getElementById("url_field").value = url;
            }
            popup.style.display = "flex";

        }

        function closePopup() {
            popupOpen = false;
            popup.style.display = "none";
            document.getElementById("name_field").value = "";
            document.getElementById("url_field").value = "";
        }

        function addService() {
            let name = document.getElementById("name_field").value;
            let url = document.getElementById("url_field").value;
            window.location.href = "/addService/" + name + "/'" + url + "'/" + document.getElementById("https_field").checked;
        }
    </script>
</body>

</html>
