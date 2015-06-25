document.addEventListener("DOMContentLoaded", function() {
    // Check date
    [].forEach.call(document.querySelectorAll(".check_date"), function(el) {
        el.addEventListener("change", function() {
            IsCorrectDate(el.value);
        });
    });

    [].forEach.call(document.querySelectorAll('.check_int'), function(el) {
        el.addEventListener("change", function() {
            var v = parseInt(el.value);
            if (isNaN(v))
            {
                alert('Incorrect number!');
                v = '';
            }
            el.value = v;
        });
    });

    [].forEach.call(document.querySelectorAll('#submitAddScore'), function(el) {
        el.addEventListener("click", function() {
            var uname = document.getElementById('uName').value;
            var uscore = document.getElementById('uScore').value;
            var udate = document.getElementById('uDate').value;
            if (!uname || !uscore || !udate ) { alert('All fields are required!'); }
            else if (IsCorrectDate(udate))
            {
                var params = 'name=' + encodeURIComponent(uname) + '&score=' + encodeURIComponent(uscore) + '&date=' + encodeURIComponent(udate);
                putData('_command.php?cmd=save_scores', callViewWin, params);
            }
        });
    });
});

function IsCorrectDate(val)
{
    var v = val.split(".");
    var d = new Date(v[2], v[1], v[0]);
    if (d == 'Invalid Date' || (d.getFullYear() != v[2] || d.getMonth() != v[1] || d.getDate() != v[0]))
    {
        alert('Incorrect date!');
        ret = false;
    }
    else
    {
        ret = true;
    }
    return ret;
}

putData = function(url, callback, params)
{
    initXMLHTTP('post', url, callback, params);
}

function callViewWin(res)
{
    window.parent.top.frames[VIEW_SCORE_WIN_NAME].ReviewScores();
}
