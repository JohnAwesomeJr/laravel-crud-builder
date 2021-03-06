<?php
$projectName = 'testLaravel';
$globalName = 'hotel';
$globalMaxNumberPerPage = 2;
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
    [
        'type' => 'selectList',
        'name' => 'Other',
        'htmlInputType' => 'select',
        'databaseName' => 'party',
        'columnShown' => 'location',
        'IdCollumnForThisTable' => 'party_id',
        'ForenIdColumn' => 'id'
    ],
    [
        'type' => 'oneToMany',
        'name' => 'comments',
        'databaseName' => 'comments',
        'IdCollumnForThisTable' => 'id',
        'ForenIdColumn' => 'commentParent',
        'collumns' => [
            [
                'type' => 'dbRow',
                'name' => 'userName',
                'htmlInputType' => 'text'
            ],
            [
                'type' => 'dbRow',
                'name' => 'commentBody',
                'htmlInputType' => 'text'
            ],
            [
                'type' => 'dbRow',
                'name' => 'commentParent',
                'htmlInputType' => 'number'
            ],
        ]

    ],
    [
        'type' => 'oneToMany',
        'name' => 'contributer',
        'databaseName' => 'contributer',
        'IdCollumnForThisTable' => 'id',
        'ForenIdColumn' => 'hotelId',
        'collumns' => [
            [
                'type' => 'dbRow',
                'name' => 'name',
                'htmlInputType' => 'text'
            ],
            [
                'type' => 'dbRow',
                'name' => 'hotelId',
                'htmlInputType' => 'number'
            ],
        ]

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