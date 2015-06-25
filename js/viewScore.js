
document.addEventListener("DOMContentLoaded", function() {
    // Change type of period
    [].forEach.call(document.querySelectorAll(".viewMenu td"), function(el) {
        el.addEventListener("click", function() {
            /* Clear other active links */
            var tr = this.parentNode.getElementsByTagName('td');
            for(var i=0; i<tr.length; i++)
            {
                tr[i].setAttribute('class','');
            }
            
            this.setAttribute('class','active');
            var id = this.id;
            LoadByType(id ? id.substring(0,1) : '');
        });
    });
    
    // Change page
    [].forEach.call(document.querySelectorAll(".paging div"), function(el) {
        el.addEventListener("click", function() {
//            /* Disable/enable */
//            var d = this.parentNode.getElementsByTagName('div');
//            for(var i=0; i<d.length; i++)
//            {
//                d[i].setAttribute('class','');
//            }
            
            if (this.id == 'next')
            {
                if (page >= max_page) { return; }
                page++;
            }
            if (this.id == 'prev')
            {
                if (page <= 1) { return; }
                page--;
            }
            
            LoadByPage(page);
        });
    });
});

//getData = function(url, callback)
//{
//    var XMLHTTP;
//    if (window.XMLHttpRequest)
//    {
//        // code for IE7+, Firefox, Chrome, Opera, Safari
//        XMLHTTP = new XMLHttpRequest();
//    }
//    else {
//        // code for IE6, IE5
//        XMLHTTP = new ActiveXObject("Microsoft.XMLHTTP");
//    }
//
//    XMLHTTP.onreadystatechange = function()
//    {
//        if (XMLHTTP.readyState == XMLHttpRequest.DONE )
//        {
//           if(XMLHTTP.readyState==4 && XMLHTTP.status==200)
//           {
//               callback(XMLHTTP.responseText);
//           }
//           else
//           {
//              alert('There was an error ' + XMLHTTP.status)
//           }
//        }
//    }
//    XMLHTTP.open('GET', url, true);
//    XMLHTTP.send();
//}

getData = function(url, callback)
{
    initXMLHTTP('get', url, callback, null);
}

function LoadByType(type)
{
    period = type;
    page = 1;
    getData('_command.php?cmd=get_scores&page='+page+'&period='+type, ReDrawScoreTableByPeriod);
}

function LoadByPage(p)
{
    page = p;
    getData('_command.php?cmd=get_scores&page='+p+'&period='+period, ReDrawScoreTableByPage);
}

function ReviewScores()
{
    getData('_command.php?cmd=get_scores&page='+page+'&period='+period, ReDrawScoreTableByPage);
}

function ReDrawScoreTableByPeriod(data)
{
    FullTable(JSON.parse(data));
    page = 1;
    max_page = CalcMaxPage();
}

function ReDrawScoreTableByPage(data)
{
    FullTable(JSON.parse(data));
    ReDrawPager();
}

function FullTable(data)
{
    var t = document.getElementById('scoreTable');
    t = t.childNodes[0];
    t = t.getElementsByTagName('tr');
    for(var i=1; i<t.length; i++)
    {
        var tr = t[i].getElementsByTagName('td');
        var j = i-1;
        if (j in data && 'sm' in data[j] && 'uname' in data[j])
        {
            tr[0].innerHTML = (page-1) * numRows + i;
            tr[1].innerHTML = data[j]['uname'];
            tr[2].innerHTML = data[j]['sm'];
        }
        else
        {
            tr[0].innerHTML = '&nbsp;';
            tr[1].innerHTML = '&nbsp;';
            tr[2].innerHTML = '&nbsp;';
        }
    }
}

function CreateTable(where)
{
    var sTable=document.createElement("table");
    sTable.setAttribute('id','scoreTable');
    var newRow = sTable.insertRow(0);
    var c = newRow.insertCell(0);
    c.innerHTML = 'Rank';
    var c = newRow.insertCell(1);
    c.innerHTML = 'Name';
    var c = newRow.insertCell(2);
    c.innerHTML = 'Score';
    
    for (i=1; i<=numRows; i++)
    {
        var newRow = sTable.insertRow(i);
        newRow.insertCell(0);
        newRow.insertCell(1);
        newRow.insertCell(2);
    }
    var d = document.getElementById(where);
    d.appendChild(sTable);
}

function CalcMaxPage()
{
    getData('_command.php?cmd=get_max_page&portion='+numRows+'&period='+period, function(data) {
        max_page = data;
        ReDrawPager();
    });
}

function ReDrawPager()
{
    if (max_page == 1) 
    {
        document.getElementById('prev').setAttribute('class','disabled');
        document.getElementById('next').setAttribute('class','disabled');
    }

    document.getElementById('prev').setAttribute('class','');
    document.getElementById('next').setAttribute('class','');

    if (page<=1) { document.getElementById('prev').setAttribute('class','disabled'); }
    if (max_page == page) { document.getElementById('next').setAttribute('class','disabled'); }
}