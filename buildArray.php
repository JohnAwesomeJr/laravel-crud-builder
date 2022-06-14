<?php
$projectName = 'testLaravel';
$globalName = 'hotel';
$globalMaxNumberPerPage = 5;
$globalColumns = array(
    [
        'type' => 'dbRow',
        'name' => 'name',
        'htmlInputType' => 'text'
    ],
    [
        'type' => 'dbRow',
        'name' => 'location',
        'htmlInputType' => 'text'
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
    // [
    //     'type' => 'selectList',
    //     'name' => 'Parts',
    //     'htmlInputType' => 'select',
    //     'databaseName' => 'parts',
    //     'columnShown' => 'partNumber',
    //     'IdCollumnForThisTable' => 'selectListDropdown',
    //     'ForenIdColumn' => 'id'

    // ],

    // [
    //     'type' => 'selectList',
    //     'name' => 'dropdown',
    //     'htmlInputType' => 'select',
    //     'databaseName' => 'party',
    //     'columnShown' => 'location',
    //     'IdCollumnForThisTable' => 'party_id',
    //     'ForenIdColumn' => 'id'

    // ],
    // [
    //     'type' => 'oneToMany',
    //     'name' => 'comments',
    //     'databaseName' => 'comments',
    //     'IdCollumnForThisTable' => 'id',
    //     'ForenIdColumn' => 'commentParent'
    // ],
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