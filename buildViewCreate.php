<?php
/* -------------------------------------------------------------------------- */
/*                             // make create view                            */
/* -------------------------------------------------------------------------- */
$output = <<<EOD
<a href='{{ url('{$globalUrl}') }}'>BACK</a><br>
<hr>
<p style="color:lightgreen; background:black">
    @if (session('statusMessage'))
        {{ session('statusMessage') }}
    @endif
</p>
@php
\$id = '';
if (isset(\$_GET['fromOneToMany'])) {
    \$id = \$_GET['iDlink'];
}
@endphp
{{\$id}}
<form action='{{ url('{$globalUrl}') }}' method='post'>
    @csrf \n
EOD;
foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $thisElement = <<<EOD
        <input name='{$globalColumns[$key]['name']}' type='{$globalColumns[$key]['htmlInputType']}'>:{$globalColumns[$key]['name']}
        <br>
        EOD;
        $output = $output . $thisElement;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $first = "<br><select name='{$globalColumns[$key]["databaseName"]}{$globalColumns[$key]["columnShown"]}'>";
        $foreach1 = <<<EOD
        @foreach(\${$globalColumns[$key]['databaseName']}{$key} as \$thisline)
            <option value="{{\$thisline->{$globalColumns[$key]['ForenIdColumn']}}}">{{\$thisline->{$globalColumns[$key]['columnShown']}}}</option>
        @endforeach
        EOD;
        $last = "</select>:{$globalColumns[$key]["name"]}<br>";
        $combine = $first . $foreach1 . $last;
        $output = $output . $combine;
    }
}

$output2 = <<<EOD2


    <input name='submit' type='submit' value='save'>
    
</form>
EOD2;

$myfile = fopen("{$globalViewFolderName}/create.blade.php", "w") or die("Unable to open file!");
$txt = $output . $output2;
fwrite($myfile, $txt);
fclose($myfile);