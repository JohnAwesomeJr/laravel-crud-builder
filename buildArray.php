<?php
$projectName = 'buildTesting';
$globalName = 'comments';
$globalMaxNumberPerPage = 5;
$globalColumns = array(
    // [
    //     'type' => 'dbRow',
    //     'name' => 'id',
    //     'htmlInputType' => 'number',
    // ],
    [
        'type' => 'dbRow',
        'name' => 'user',
        'htmlInputType' => 'text',
    ],
    [
        'type' => 'dbRow',
        'name' => 'comment',
        'htmlInputType' => 'text',
    ],
    [
        'type' => 'dbRow',
        'name' => 'parentPostId',
        'htmlInputType' => 'text',
    ],
);


$globalUrl = $globalName;
$globalDatabaseName = $globalName . 's';
$globalControllerVariableName = 'ControllerPassedVar';
/* -------------------------------------------------------------------------- */
/*                           // make directory tree                           */
/* -------------------------------------------------------------------------- */
$globalViewFolderName = "{$projectName}/resources/views/{$globalDatabaseName}";
$globalControllerFolderName = "{$projectName}/app/Http/Controllers";
$globalModelFolderName = "{$projectName}/app/Models";

if (!file_exists($globalViewFolderName)) {
    mkdir($globalViewFolderName, 0777, true);
}
if (!file_exists($globalControllerFolderName)) {
    mkdir($globalControllerFolderName, 0777, true);
}
if (!file_exists($globalModelFolderName)) {
    mkdir($globalModelFolderName, 0777, true);
}