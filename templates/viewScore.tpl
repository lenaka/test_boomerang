<html>
    <head>
        <meta charset="UTF-8"/>
        <base dir="./"/>
        <link rel="stylesheet" type="text/css" href="style/main.css" />
        <link rel="stylesheet" type="text/css" href="style/viewScore.css" />
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/viewScore.js"></script>
    </head>
    <body>
        <table class='viewMenu'>
            <tr><td class='active' id='d_PType'>Daily</td><td id='w_PType'>Weekly</td><td id='m_PType'>Monthly</td><td>All Time</td></tr>
        </table>
        <div id='viewScore'></div>
        <div class='paging' id='pager'>
            <div id='prev' class='disabled'>&lt;&lt; Prev</div>
            <div id='next'>Next &gt;&gt;</div>
        </div>

        <script type="text/javascript">
             var scores = '<?= $param['scoreData']?>';
             var numRows = '<?= $param['portion']?>';
             var page = '<?= $param['page']?>';
             var period = 'd';
             var max_page;

             CreateTable('viewScore');
             ReDrawScoreTableByPeriod(scores);
        </script>
    </body>
</html>
