<html>
    <head>
        <meta charset="UTF-8"/>
        <base dir="./"/>
        <link rel="stylesheet" type="text/css" href="style/main.css" />
        <link rel="stylesheet" type="text/css" href="style/addScore.css" />
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/addScore.js"></script>
        <script type="text/javascript">
            var VIEW_SCORE_WIN_NAME = "<?= $viewScoreWinName?>";
        </script>
    </head>
    <body>
        <form class="formAddScore">
            <table>
                <tr><td>Name:</td><td><input type="text" id="uName" name="uName"/></td></tr>
                <tr><td>Score:</td><td><input type="text" id="uScore" name="uScore" class="check_int"/></td></tr>
                <tr><td>Date:</td><td><input type="text" id="uDate" name="uDate" class="check_date"/></td></tr>
                <tr><td></td><td><input type="button" id="submitAddScore" value="Save"/></td></tr>
            </table>
        </form>
    </body>
</html>
