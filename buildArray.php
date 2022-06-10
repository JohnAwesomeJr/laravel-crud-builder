<?php
$projectName = 'testLaravel';
$globalName = 'assembly';
$globalMaxNumberPerPage = 5;
$globalColumns = array(
    [
        'type' => 'dbRow',
        'name' => 'part',
        'htmlInputType' => 'text'
    ],
    [
        'type' => 'dbRow',
        'name' => 'car',
        'htmlInputType' => 'text'
    ],
    [
        'type' => 'dbRow',
        'name' => 'driver',
        'htmlInputType' => 'number'
    ],
    // [
    //     'type' => 'relational',
    //     'databaseName' => 'selectList',
    //     'name' => 'parts',
    //     'htmlInputType' => 'crud',
    //     'tables' => [
    //         'partNumber' => 'text',
    //         'quantity' => 'number'
    //     ]
    // ],
    [
        'type' => 'selectList',
        'name' => 'Parts',
        'htmlInputType' => 'select',
        'databaseName' => 'parts',
        'columnShown' => 'partNumber',
        'IdCollumnForThisTable' => 'selectListDropdown',
        'ForenIdColumn' => 'id'

    ],

    [
        'type' => 'selectList',
        'name' => 'Other',
        'htmlInputType' => 'select',
        'databaseName' => 'parents',
        'columnShown' => 'kid1',
        'IdCollumnForThisTable' => 'parentsRelationship',
        'ForenIdColumn' => 'id'

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