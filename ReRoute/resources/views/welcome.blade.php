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
        <div class="reItem" id="addButton" style="background-color: transparent;">
            Add
        </div>
    </div>
    <script>
        var data;
        //fetch data from file
        async function fetchData() {
            const response = await fetch('data.json');
            data = await response.json();
  
        }
        fetchData().then(() => {
            data.forEach((item) => {
                addReItem(item.name,item.url);
            });
        });

        

        var reItems = document.getElementsByClassName("reItem");

        function addReItem(name,url) {
            var reItem = document.createElement("div");
            reItem.classList.add("reItem");
            reItem.innerHTML = name;
            document.getElementById("container").appendChild(reItem);
            document.getElementById("addButton").insertAdjacentElement("beforebegin", reItem);
            reItem.addEventListener("click", () => {
                window.location.href = url;
            });
        }
        document.getElementById("addButton").addEventListener("click", () => {
            //popup
        })

    </script>
</body>

</html>