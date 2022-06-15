<?php
/* -------------------------------------------------------------------------- */
/*                             //  make edit view                             */
/* -------------------------------------------------------------------------- */
$output = <<<EOD
<style>
.oneToMany{
    border:solid 1px black; 
    width:fit-content; 
    padding:20px;
}
</style>
<a href='{{ url('$globalUrl') }}'>BACK</a><br>
<hr>
<p style="color:lightgreen; background:black">
    @if (session('statusMessage'))
        {{ session('statusMessage') }}
    @endif
</p>
<form action='{{ url('{$globalUrl}/' . \${$globalControllerVariableName}->id) }}' method='post'>
    @csrf
    @method('put')
    <br>
EOD;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $thisElement = <<<EOD
    <br>
    <input value='{{ \${$globalControllerVariableName}->{$globalColumns[$key]['name']} }}' name='{$globalColumns[$key]['name']}' type='{$globalColumns[$key]['htmlInputType']}'>:{$globalColumns[$key]['name']}
    <br>
    EOD;
        $output = $output . $thisElement;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $first = "<br><select name='{$globalColumns[$key]["databaseName"]}{$globalColumns[$key]["columnShown"]}'>";
        $foreach1 = <<<EOD
        @foreach(\${$globalColumns[$key]['databaseName']}{$key} as \$thisline)
        @if(\$thisline->{$globalColumns[$key]['ForenIdColumn']} == \${$globalControllerVariableName}->{$globalColumns[$key]["IdCollumnForThisTable"]})
        <option value="{{\$thisline->{$globalColumns[$key]['ForenIdColumn']}}}" selected>{{\$thisline->{$globalColumns[$key]['columnShown']}}}</option>
        @else
        <option value="{{\$thisline->{$globalColumns[$key]['ForenIdColumn']}}}">{{\$thisline->{$globalColumns[$key]['columnShown']}}}</option>
        @endif
        @endforeach
        EOD;
        $last = "</select>:{$globalColumns[$key]["name"]}<br>";
        $combine = $first . $foreach1 . $last;
        $output = $output . $combine;
    }
}

$output2 = <<<EOD
<br><br>
    <input name='submit' type='submit' value='save'>
</form>
<form action='{{ url('{$globalUrl}/' . \${$globalControllerVariableName}->id) }}' method='post'>
    @csrf
    @method('DELETE')
    <button type='submit'>Delete</button>
</form>
EOD;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'oneToMany') {
        $dbName = $globalColumns[$key]['databaseName'];
        $thisLineOne = $globalColumns[$key]['collumns'];
        $center = '';
        foreach ($thisLineOne as $key1 => $value) {
            $contentValue = '{{' . '$thisLineOne->' . $thisLineOne[$key1]['name'] . '}}';
            $inputType = '{{' . '$thisLineOne->' . $thisLineOne[$key1]['htmlInputType'] . '}}';
            $input = '<input' . " value=\"{$contentValue}\" " . " type=\"{$inputType}\"" . "name=\"{$thisLineOne[$key1]['name']}\"" . ">:{$thisLineOne[$key1]['name']}<br><br>";
            $center = $center . $input;
        }
        $thisId = '{{' . '$thisLineOne->' . 'id' . '}}';
        $one = <<<EOD
        <style>
        .h-5 {
            height: 20px;
        }
        </style>
        <h1>{$globalColumns[$key]['name']}</h1>
        <a href='{{ url("{$globalColumns[$key]['name']}/create?fromOneToMany=true&iDlink={\$id}") }}'>ADD NEW {$globalColumns[$key]['name']}</a>
        @foreach(\${$dbName}{$key} as \$thisLineOne)
        <div class="oneToMany">
        <form action='{{ url('{$dbName}/' . \$thisLineOne->id) }}' method='post'>
        @csrf
        @method('put')
        {$globalColumns[$key]['name']} ID: {$thisId} <br>
        EOD;

        $two = <<<EOD
        <input name='submit' type='submit' value='save'>

        </form>
        <form action='{{ url('{$dbName}/' . \$thisLineOne->id) }}' method='post'>
            @csrf
            @method('DELETE')
            <button type='submit'>Delete</button>
        </form>
        </div>
        @endforeach
        {!! \${$dbName}{$key}->links() !!}
        EOD;
        $combine = $one . $center . $two;
        $output2 = $output2 . $combine;
    }
}
$myfile = fopen("{$globalViewFolderName}/edit.blade.php", "w") or die("Unable to open file!");
$txt = $output . $output2;
fwrite($myfile, $txt);
fclose($myfile);