<?php
include('config.php');
logincheck();

$message = [];
$title = "Create ipblock";
$ipblock = new BlockedIp;
$edit = 0;

if (isset($_GET['id'])) {
    $title = "Edit ipblock";
    $ipblock = BlockedIp::find($_GET['id']);
}

if (isset($_POST['submit'])) {
    $errorr = 0;
    $exists = BlockedIp::where('ip', '=', $_POST['ip'])->get();
    if (empty($_POST['ip'])) {
        $message['type'] = "error";
        $message['message'] = "O campo IP não pode estar em branco";
        $errorr = 1;
    }

    if ($errorr == 0) {
        $message['type'] = "Successo";
        if (isset($_GET['id'])) {
            $message['message'] = "ipblock editado";
        } else {
            $message['message'] = "ipblock criado";
        }


        $ipblock->ip = $_POST['ip'];
        $ipblock->description = $_POST['description'];
        $ipblock->save();

        redirect("manage_ipblock.php?id=" . $ipblock->id, 2000);
    }
}

echo $template->view()->make('manage_ipblock')
    ->with('ipblock', $ipblock)
    ->with('message', $message)
    ->with('title', $title)
    ->render();
