<?php
/* -------------------------------------------------------------------------- */
/*                             //  make edit view                             */
/* -------------------------------------------------------------------------- */
$output = <<<EOD
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


    $center = '';
    if ($globalColumns[$key]['type'] == 'oneToMany') {
        $dbName = $globalColumns[$key]['databaseName'];
        $thisLineOne = $globalColumns[$key]['collumns'];

        foreach ($thisLineOne as $key1 => $value) {
            $lineItem = '{{' . '$thisLineOne->' . $thisLineOne[$key1]['name'] . '}}' . '<br>';
            $center = $center . $lineItem;
        }

        $one = <<<EOD
        @foreach(\${$dbName}{$key} as \$thisLineOne)
        EOD;


        $two = <<<EOD
        @endforeach
        EOD;
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
$myfile = fopen("{$globalViewFolderName}/edit.blade.php", "w") or die("Unable to open file!");
$txt = $output . $one . $center . $two . $output2;
fwrite($myfile, $txt);
fclose($myfile);