var data;
onmessage = (e) => {
    console.log("worker: ")
    console.log(e.data)
    startChecking(e.data);
}
async function startChecking(data) {
    while (true) {
        console.log("checking...");
        data.forEach(async element => {
            url = (element[0] == 1 ? "https://" : "http://") + element[1];
            try {
                response = await fetch(url);
                if (!response.ok) {
                    console.log("service failed");
                    postMessage(element[1]);
                }
            } catch (error) {
                postMessage(element[1]);
            }
           

        });
        await Sleep(2000);
    }
}
function Sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
}
