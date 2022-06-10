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
<form action='{{ url('{$globalUrl}') }}' method='post'>
    @csrf
EOD;
foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] != 'dbRow') {
        $thisElement = '<input placeholder="i am an array">';
        $output = $output . $thisElement;
    } else {
        $thisElement = <<<EOD
        <input name='{$globalColumns[$key]['name']}' type='{$globalColumns[$key]['htmlInputType']}'>:{$globalColumns[$key]['name']}
        <br>
        EOD;
        $output = $output . $thisElement;
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