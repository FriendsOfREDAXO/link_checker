var es;

var timerID = setInterval(function() {
    link_checker_background();
}, 60 * 1000); 
 
function link_checker_background() {
    es = new EventSource('/index.php?rex-api-call=link_checker');

    es.addEventListener('message', function(e) {
        var result = JSON.parse( e.data );
        
        console.log("linkchecker checked 1 link");
        es.close();
    });
     
    es.addEventListener('error', function(e) {
        console.log("linkchecker error");
        es.close();
    });
}
