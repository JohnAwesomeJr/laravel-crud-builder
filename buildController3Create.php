<?php
$outputController4 = <<<EDO

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    \$pushToViewArray = []; \n
    if (isset(\$_GET['fromOneToMany'])) {
        \$pushToViewArray += ['oneToManyOwner' => 'true'];
    }
EDO;
foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'selectList') {


        $thisThingIsGreat = <<<EDO
            \${$globalColumns[$key]['databaseName']}{$key} = {$globalColumns[$key]['databaseName']}s::class::all();
            \$pushToViewArray += ["{$globalColumns[$key]['databaseName']}{$key}" => \${$globalColumns[$key]['databaseName']}{$key}];
            EDO;
        $outputController4 = $outputController4 . $thisThingIsGreat;
    }
}

$outputController4_5 = <<<EDO

    return view('{$globalDatabaseName}.create',\$pushToViewArray);
}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  \$request
 * @return \Illuminate\Http\Response
 */
public function store(Request \$request, $globalDatabaseName \${$globalDatabaseName})
{
    \n
EDO;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $thisRow = <<<EDO
    \t
    \${$globalDatabaseName}->{$globalColumns[$key]['name']} = \$request->input('{$globalColumns[$key]['name']}'); \n
    EDO;
        $outputController4_5 = $outputController4_5 . $thisRow;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisRow = <<<EDO
        \${$globalDatabaseName}->{$globalColumns[$key]['IdCollumnForThisTable']} = \$request->input('{$globalColumns[$key]["databaseName"]}{$globalColumns[$key]["columnShown"]}'); \n
        EDO;
        $outputController4_5 = $outputController4_5 . $thisRow;
    }
}

$outputController5 = <<<EDO

        \${$globalDatabaseName}->save();
        return redirect()->back()->with('statusMessage', ' has been added to the database');
    }
EDO;