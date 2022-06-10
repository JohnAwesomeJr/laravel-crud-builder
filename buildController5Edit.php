<?php
$outputController7 = <<<EDO

/**
 * Show the form for editing the specified resource.
 *
 * @param  \App\Models\databaseNameExamples  \$databaseNameExamples
 * @return \Illuminate\Http\Response
 */
public function edit($globalDatabaseName \${$globalDatabaseName}, \$id)
{
    \$pushToViewArray = []; \n
EDO;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'selectList') {


        $thisThingIsGreat = <<<EDO
            \${$globalColumns[$key]['databaseName']}{$key} = {$globalColumns[$key]['databaseName']}::class::all();
            \$pushToViewArray += ["{$globalColumns[$key]['databaseName']}{$key}" => \${$globalColumns[$key]['databaseName']}{$key}];
            EDO;
        $outputController7 = $outputController7 . $thisThingIsGreat;
    }
}


$outputController8 = <<<EDO
    \$thisSinglesRow = $globalDatabaseName::find(\$id);
    \$pushToViewArray += ['{$globalControllerVariableName}' => \$thisSinglesRow];
    return view('{$globalDatabaseName}.edit', \$pushToViewArray);
}
EDO;





$outputController9 = <<<EDO

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  \App\Models\databaseNameExamples  \$databaseNameExamples
     * @return \Illuminate\Http\Response
     */
    public function update(Request \$request, $globalDatabaseName \${$globalDatabaseName}, \$id)
    {
        \${$globalControllerVariableName} = {$globalDatabaseName}::find(\$id);
EDO;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $thisRow = <<<EDO
        \${$globalControllerVariableName}->{$globalColumns[$key]['name']} = \$request->input('{$globalColumns[$key]['name']}'); \n
        EDO;
        $outputController9 = $outputController9 . $thisRow;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisRow = <<<EDO
        \${$globalControllerVariableName}->{$globalColumns[$key]['IdCollumnForThisTable']} = \$request->input('{$globalColumns[$key]["databaseName"]}{$globalColumns[$key]["columnShown"]}'); \n
        EDO;
        $outputController9 = $outputController9 . $thisRow;
    }
}



$outputController10 = <<<EDO

        \${$globalControllerVariableName}->update();
        return redirect()->back()->with('statusMessage', 'has been updated');
    }
EDO;