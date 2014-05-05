#!/usr/bin/php
<?php

error_reporting(E_ALL);

$file = $argv[1];
$json = file_get_contents($file);
$data = json_decode($json, true);

// Quick error check
if (is_null($data)) {
    print $file . " is not valid JSON. Please check it here: http://jsonformatter.curiousconcept.com/\n\n";
    exit(1);
}

$lists = array();

// Sort into lists
foreach ($data["tasks"] as $task) {

    // ignore completed
    if (isset($task["completed_at"])) {
        continue;
    }

    $list_name = $task["list_id"];

    foreach ($data["lists"] as $list) {
        if ($list["id"] == $task["list_id"]) {
            $list_name = $list["title"];
            break;
        }
    }

    if (!isset($lists[$list_name])) {
        $lists[$list_name] = array();
    }

    // add to list
    $lists[$list_name][] = $task;

}

$output = "";

// Loop through and put into new format
foreach ($lists as $list => $tasks) {

    $output .= "\n\n\n" . $list . "\n\n";

    foreach ($tasks as $task) {

        $date = date_create($task["created_at"]);
        $output .= $task["title"] . " " . "[[date " . date_format($date, "d/m Y") . "]]\n";

        if (isset($task["note"])) {
            $output .= "[[NOTE]]: " . $task["note"];
        }

    }

}

// Put into a new file
file_put_contents($file . ".todoist.txt", $output);