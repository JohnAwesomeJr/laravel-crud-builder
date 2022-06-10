<?php
$outputController4 = <<<EDO

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    return view('{$globalDatabaseName}.create');
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
        $outputController4 = $outputController4 . $thisRow;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisRow = '//i am an array';
        $outputController4 = $outputController4 . $thisRow;
    }
}

$outputController5 = <<<EDO

        \${$globalDatabaseName}->save();
        return redirect()->back()->with('statusMessage', ' has been added to the database');
    }
EDO;