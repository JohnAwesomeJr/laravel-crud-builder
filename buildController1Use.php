<?php
$outputController1 = <<<EOD
<?php

namespace App\Http\Controllers;
use App\Models\{$globalDatabaseName};
use Illuminate\Http\Request;
EOD;

$dupCheck = [];
foreach ($globalColumns as $key => $value) {
    $listTyep = $globalColumns[$key]['type'];
    if ($listTyep == 'selectList' || $listTyep == 'oneToMany') {
        $model = $globalColumns[$key]['databaseName'];
        array_push($dupCheck, $model);
    }
}
array_unique($dupCheck);
foreach ($dupCheck as $key => $value) {
    $withS = $value . 's';
    $thisOneOn = <<<EDO
        
    use App\Models\{$withS};
    
    EDO;
    $outputController1 = $outputController1 . $thisOneOn;
}

$outputController2 = <<<EDO
class {$globalDatabaseName}Controller extends Controller
{
EDO;