var link_checker = setInterval(function() {
    console.log("link_checker");
    fetch('/index.php?rex-api-call=link_checker');
}, 15 * 1000); 

link_checker;
