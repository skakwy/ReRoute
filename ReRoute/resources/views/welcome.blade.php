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
            <div class="reItem"
                onmouseover="document.getElementsByClassName('editBtn')[{{ $loop->index }}].style.opacity = 1"
                onmouseout="document.getElementsByClassName('editBtn')[{{ $loop->index }}].style.opacity = 0">
                <div style="display: flex;align-items:center;justify-content:center;width:100%">
                    <img id="{{$service->url}}" class="errorIcon" src="extra/error.svg" />
                </div>
                <a style="color: white;text-decoration: none;width:100%;text-align:center"
                    onclick="window.location.href = '{{ $service->isHttps == true ? 'https:/\/' : 'http:/\/' }}{{ $service->url }}'">{{ $service->name }}</a>
                <div style="width: 100%;display:flex;justify-content:right;height:100%">
                    <button onclick="showPopup('{{ $service->name }}','{{ $service->url }}',{{ $service->isHttps }})"
                        class="editBtn"><img style="width: 23px;height:23px" src="extra/edit.svg" /></button>
                </div>
            </div>
        @endforeach
        <div class="reItem" id="updateEvcc">
            Update Evcc
        </div>
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
                <button id="pAddButton" class="button" onclick="addService()">
                    Add
                </button>
                <button onclick="deleteService()" style="background-color:red;height:30px;font-size:18px;padding:0px;display:none" id="pDeleteButton" class="button" onclick="addService()">
                    Delete
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
        var oldName;

        document.getElementById("updateEvcc").addEventListener("click", () => {
            window.location.href = "/updateEvcc";
        })

        document.getElementById("addButton").addEventListener("click", () => {
            showPopup();
        })

        function showPopup(name = null, url = null, isHttps = null) {
            popupOpen = true;
            if (name != null && url != null && isHttps != null) {
                document.getElementById("name_field").value = name;
                document.getElementById("url_field").value = url;
                oldName = name;
                oldUrl = url;
                document.getElementById("https_field").checked = isHttps;
                document.getElementById("pAddButton").innerHTML = "change";
                document.getElementById("pDeleteButton").style.display = "block";
            }
            popup.style.display = "flex";


        }

        function closePopup() {
            popupOpen = false;
            popup.style.display = "none";
            document.getElementById("name_field").value = "";
            document.getElementById("url_field").value = "";
            document.getElementById("pDeleteButton").style.display = "none";
        }

        function addService() {
            if (document.getElementById("pAddButton").innerHTML == "change") {
                let name = document.getElementById("name_field").value;
                let url = document.getElementById("url_field").value;
                //console.log("/changeService/" + name + "/'" + url + "'/" + document.getElementById("https_field").checked)
                window.location.href = "/changeService/" + oldName + "/" + document.getElementById("https_field").checked +
                    "/" + name + "/'" + url + "'";
            } else {

                let name = document.getElementById("name_field").value;
                let url = document.getElementById("url_field").value;
                window.location.href = "/addService/" + name + "/'" + url + "'/" + document.getElementById("https_field")
                    .checked;
            }
        }
        function deleteService(){
            window.location.href = "/deleteService/" + oldName;
        }
        //status check
        if (window.Worker) {
            const statusWorker = new Worker("js/worker.js");
            var services = [];
            @foreach ($services as $service)
                services.push([{{$service->isHttps}},'{{ $service->url }}']);
            @endforeach
            statusWorker.postMessage(services);
            statusWorker.onmessage = (e) => {
                if(e.data[0] == "-"){
                document.getElementById(e.data.substring(1,e.data.length)).style.opacity = 1;
                }
                else{
                    document.getElementById(e.data.substring(1,e.data.length)).style.opacity = 0;
                }
            };
        }
    </script>
</body>

</html>
