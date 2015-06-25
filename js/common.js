
function initXMLHTTP(type, url, callback, data)
{
    var XMLHTTP;
    var sData = data;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        XMLHTTP = new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        XMLHTTP = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    XMLHTTP.onreadystatechange = function()
    {
        if (XMLHTTP.readyState == XMLHttpRequest.DONE )
        {
           if(XMLHTTP.readyState==4 && XMLHTTP.status==200)
           {
               callback(XMLHTTP.responseText);
           }
           else
           {
              alert('There was an error ' + XMLHTTP.status)
           }
        }
    }
    
    XMLHTTP.open(type, url, true);
    // Put data to server
    if (sData)
    {
        XMLHTTP.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        XMLHTTP.send(data);
    }
    else
    {
        XMLHTTP.send();
    }
}