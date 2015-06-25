<?php
require_once 'lib/Command.php';
require_once 'lib/ControlUserScore.php';

$c = new Command($config);

$data = array();
foreach (array_keys($_GET) as $k)
{
    if ($k != 'cmd') { $data[$k] = filter_input(INPUT_GET, $k); }
}
foreach (array_keys($_POST) as $k)
{
    if ($k != 'cmd') { $data[$k] = filter_input(INPUT_POST, $k); }
}
echo $c->Execute(filter_input(INPUT_GET, 'cmd'), $data);
