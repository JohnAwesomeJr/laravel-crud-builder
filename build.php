<?php
$projectName = 'testLaravel';
$globalName = 'assembly';
$globalMaxNumberPerPage = 15;
$globalColumns = array(
    [
        'type' => 'dbRow',
        'name' => 'part',
        'htmlInputType' => 'text'
    ],
    [
        'type' => 'dbRow',
        'name' => 'car',
        'htmlInputType' => 'text'
    ],
    [
        'type' => 'dbRow',
        'name' => 'driver',
        'htmlInputType' => 'number'
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
    [
        // @todo test array
        'type' => 'selectList',
        'name' => 'selectList',
        'htmlInputType' => 'select',
        'databaseName' => 'parts',
        'columnShown' => 'partNumber',
        'IdCollumnForThisTable' => 'selectListDropdown',
        'ForenIdColumn' => 'id'

    ],
);
echo '<pre>';
print_r($globalColumns);
echo '<pre>';






// Use the below code on the create and edit if you want one of the inputs to be a dropdown of a database.
// <select name='part'>
//     @foreach ($list as $line)
//         @if ($ControllerPassedVar->part == $line->partNumber)
//             <option value="{{ $line->partNumber }}" selected>{{ $line->partNumber }}</option>
//         @else
//             <option value="{{ $line->partNumber }}">{{ $line->partNumber }}</option>
//         @endif
//     @endforeach
// </select>

function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}



$globalUrl = $globalName;
$globalDatabaseName = $globalName . 's';


$globalControllerVariableName = 'ControllerPassedVar';
$globalViewFolderName = "{$projectName}/resources/views/{$globalDatabaseName}";
$globalControllerFolderName = "{$projectName}/app/Http/Controllers";
$globalModelFolderName = "{$projectName}/app/Models";




/* -------------------------------------------------------------------------- */
/*                           // make directory tree                           */
/* -------------------------------------------------------------------------- */

if (!file_exists($globalViewFolderName)) {
    mkdir($globalViewFolderName, 0777, true);
}
if (!file_exists($globalControllerFolderName)) {
    mkdir($globalControllerFolderName, 0777, true);
}
if (!file_exists($globalModelFolderName)) {
    mkdir($globalModelFolderName, 0777, true);
}

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
    // @todo select list in view
    if ($globalColumns[$key]['type'] == 'selectList') {
        $first = "<select name='{$globalColumns[$key]["databaseName"]}{$globalColumns[$key]["columnShown"]}'>";
        $foreach1 = <<<EOD
        @foreach(\${$globalColumns[$key]['databaseName']}{$key} as \$thisline)
        
        <option value="{{\$thisline->{$globalColumns[$key]['ForenIdColumn']}}}">{{\$thisline->{$globalColumns[$key]['columnShown']}}}</option>
        @endforeach
        EOD;
        $last = '</select>';
        $combine = $first . $foreach1 . $last;
        $output = $output . $combine;
    }
}

$output2 = <<<EOD

    <input name='submit' type='submit' value='save'>
</form>

<br>
<form action='{{ url('{$globalUrl}/' . \${$globalControllerVariableName}->id) }}' method='post'>
    @csrf
    @method('DELETE')
    <button type='submit'>Delete</button>
</form>
EOD;
$myfile = fopen("{$globalViewFolderName}/edit.blade.php", "w") or die("Unable to open file!");
$txt = $output . $output2;
fwrite($myfile, $txt);
fclose($myfile);

/* -------------------------------------------------------------------------- */
/*                             // Make index File                             */
/* -------------------------------------------------------------------------- */

$output = <<<EOD
<style>
table {
  table-layout: fixed;
  border-collapse: collapse;
  width: 100%;
  max-width: 900px;
  }
  td{
    text-align:center;
    padding: 20px;
    overflow: hidden;
    white-space: nowrap;
    width: fit-content;
    border: solid 1px #000;
  }
  </style>
<a href='{{ url('{$globalUrl}/create') }}'>ADD</a>
<hr>
<p style="color:lightgreen; background:black">
    @if (session('statusMessage'))
        {{ session('statusMessage') }}
    @endif
</p>
<table>
<thead>
<tr>
<th>EDIT</th>
<th>DELETE</th>
EOD;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $tackOn = '<th>' . strtoupper($globalColumns[$key]['name']) . '</th>';
        $output = $output . $tackOn;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $tackOn = '<th>' . strtoupper($globalColumns[$key]['name']) . '</th>';
        $output = $output . $tackOn;
    }
}

$outputNew = <<<EOD
<th>ID</th>
</tr>
</thead>
<tbody>
<tr>
@foreach (\${$globalControllerVariableName} as \$line)
    <td>
        <a href='{$globalUrl}/{{ \$line->id }}/edit'>✏️</a>
    </td>

    <td>
        <form action='{{ url('{$globalUrl}/' . \$line->id) }}' method='post'
        style="display: inline;">
        @csrf
        @method('DELETE')
        <button name='delete' type='submit'>🗑️</button>
        </form>
    </td>
EOD;
$output = $output . $outputNew;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'dbRow') {
        $thisLIneItem = "<td>{{ \$line->{$globalColumns[$key]['name']} }} </td>";
        $output = $output . $thisLIneItem;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisLIneItem = "<td>{{ \$line->{$globalColumns[$key]['name']}->{$globalColumns[$key]['columnShown']} }}</td>";
        $output = $output . $thisLIneItem;
    }
}

$output3 = <<<EOD
    <td>
        {{ \$line->id }}
    </td>
    </tr>
@endforeach
</tbody>
</table>
<style>
    .h-5 {
        height: 20px;
    }

</style>
{!! \${$globalControllerVariableName}->links() !!}
EOD;

$myfile = fopen("{$globalViewFolderName}/index.blade.php", "w") or die("Unable to open file!");
$txt = $output . $output3;
fwrite($myfile, $txt);
fclose($myfile);

/* -------------------------------------------------------------------------- */
/*                             // Make model file                             */
/* -------------------------------------------------------------------------- */

$output = <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$globalDatabaseName} extends Model
{
    use HasFactory;

EOD;
foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisThing = <<<MIKEEDO
    public function {$globalColumns[$key]['name']}()
    {
        return \$this->belongsTo({$globalColumns[$key]['databaseName']}::class, '{$globalColumns[$key]['IdCollumnForThisTable']}', '{$globalColumns[$key]['ForenIdColumn']}');
    }
    MIKEEDO;
        $output = $output . $thisThing;
    }
}
$output2 = <<<EOD
}
EOD;
$myfile = fopen("{$globalModelFolderName}/{$globalDatabaseName}.php", "w") or die("Unable to open file!");
$txt = $output . $output2;
fwrite($myfile, $txt);
fclose($myfile);

/* -------------------------------------------------------------------------- */
/*                           // make controller file                          */
/* -------------------------------------------------------------------------- */

$outputStart = <<<EOD
<?php

namespace App\Http\Controllers;
use App\Models\{$globalDatabaseName};
use Illuminate\Http\Request;
EOD;

$output = <<<EDO
class {$globalDatabaseName}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
EDO;
// top part oc controller
foreach ($globalColumns as $key => $value) {
    $listTyep = $globalColumns[$key]['type'];

    if ($listTyep == 'selectList') {
        $model = $globalColumns[$key]['databaseName'];
        $import = <<<EDO
        
        use App\Models\{$model};
        \n
        EDO;
        $outputStart = $outputStart . $import;
    }
}



$outputnew = <<<EDO
        \${$globalControllerVariableName} = {$globalDatabaseName}::orderBy('id', 'DESC')->paginate({$globalMaxNumberPerPage});
        return view('{$globalDatabaseName}.index', ['{$globalControllerVariableName}' => \${$globalControllerVariableName}]);
    }

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
        $outputnew = $outputnew . $thisRow;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisRow = '//i am an array';
        $outputnew = $outputnew . $thisRow;
    }
}

$output2 = <<<EDO
        \${$globalDatabaseName}->save();
        return redirect()->back()->with('statusMessage', ' has been added to the database');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\databaseNameExamples  \$databaseNameExamples
     * @return \Illuminate\Http\Response
     */
    public function show($globalDatabaseName \${$globalDatabaseName})
    {
        // return \${$globalDatabaseName};
        return 'show';
    }

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
// edit controller
foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'selectList') {


        $thisThingIsGreat = <<<EDO
                \${$globalColumns[$key]['databaseName']}{$key} = {$globalColumns[$key]['databaseName']}::class::all();
                \$pushToViewArray += ["{$globalColumns[$key]['databaseName']}{$key}" => \${$globalColumns[$key]['databaseName']}{$key}];
                EDO;
        $output2 = $output2 . $thisThingIsGreat;
    }
}


$outputMiddle = <<<EDO
        \$thisSinglesRow = $globalDatabaseName::find(\$id);
        \$pushToViewArray += ['{$globalControllerVariableName}' => \$thisSinglesRow];
        return view('{$globalDatabaseName}.edit', \$pushToViewArray);
    }

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
        $outputMiddle = $outputMiddle . $thisRow;
    }
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisRow = '//i am an array';
        $outputMiddle = $outputMiddle . $thisRow;
    }
}



$output3 = <<<EDO
        \${$globalControllerVariableName}->update();
        return redirect()->back()->with('statusMessage', 'has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\databaseNameExamples  \$databaseNameExamples
     * @return \Illuminate\Http\Response
     */
    public function destroy($globalDatabaseName \${$globalDatabaseName}, \$id)
    {
        \${$globalDatabaseName} = {$globalDatabaseName}::find(\$id);
        \${$globalDatabaseName}->delete();
        return redirect('{$globalUrl}')->with('statusMessage', ' has been deleted');
    }
}
EDO;
$myfile = fopen("{$globalControllerFolderName}/{$globalDatabaseName}Controller.php", "w") or die("Unable to open file!");
$txt = $outputStart . $output . $outputnew . $output2 . $outputMiddle . $output3;
fwrite($myfile, $txt);
fclose($myfile);
















$controllerNameJoined = $globalDatabaseName . 'Controller';
$output = <<<EDO
<style>
div{
background: lightGray;
padding:20px;
}
</style>
<h1>One More Step</h1>
<p>Please copy and paste the code below and place it in the web.php Routes file. <br></p>
<div>
use App\Http\Controllers\{$controllerNameJoined};
<br>
Route::resource('{$globalUrl}', {$globalDatabaseName}Controller::class);
</div>
EDO;

echo $output;