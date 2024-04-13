var data;
onmessage = (e) => {
    startChecking(e.data);
}
async function startChecking(data) {
    while (true) {
        data.forEach(async element => {
            url = (element[0] == 1 ? "https://" : "http://") + element[1];
            try {
                if(element[0] == 1){
                response = await fetch(url,{mode: 'no-cors'});
                }
                else{
                    response = await fetch(url);
                }
                if (!response.ok) {
                    console.log("service" + url + "failed with response: ");
                    console.log(response);
                    postMessage("-" + element[1]);
                }
                else{
                    postMessage("+" + element[1]);
                }
            } catch (error) {
                console.log(error)
                postMessage("-" + element[1]);
            }
           

        });
        await Sleep(2000);
    }
}
function Sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
}
