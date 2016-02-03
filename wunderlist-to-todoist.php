#!/usr/bin/php
<?php

# Language Settings
mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_detect_order("UTF-8,JIS,SJIS,EUC-JP,ASCII");
mb_substitute_character("");

# Timezone Setting
date_default_timezone_set("Asia/Tokyo");
error_reporting(E_ALL);

$file = $argv[1];
$json = file_get_contents($file);
$root = json_decode($json, true);
$data = $root["data"];

// Quick error check
if (is_null($data) || is_null($data["tasks"])) {
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

        $date = "";

        if (isset($task["due_date"])) {
            $dateObj = date_create($task["due_date"]);
            $date = " [[date " . date_format($dateObj, "d/m Y") . "]]";
        }

        $output .= $task["title"] . $date . "\n";

        if (isset($task["note"])) {
            $output .= "[[NOTE]]: " . $task["note"];
        }

    }

}

// Put into a new file
file_put_contents($file . ".todoist.txt", $output);
