run();
async function run(){
   
    while(true){
        const d = new Date();
        response = await (await fetch("http://localhost/api/cpuUsage")).json();
        if(response.cpu*100 <= 100){
        postMessage({"time":d.toLocaleTimeString(),"cpu":Math.floor(response.cpu*100)});
        }
        else{
            console.log("inavlid response: " + response.cpu*100);
        }
        
    }
}
function Sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
}