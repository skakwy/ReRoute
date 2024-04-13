    document.addEventListener("keydown", (key) =>{
        if(key.code == 'Enter'){
            if(document.activeElement == document.getElementById("password_field")){
                login();
            }
            if(document.activeElement == document.getElementById("name_field")){
                login();
            }
        }
    })


function login() {
    var name = document.getElementById('name_field').value;
    var password = document.getElementById('password_field').value;
    window.location.href = "/login/" + name + "/" + password;
}