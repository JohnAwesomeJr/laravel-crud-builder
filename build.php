<?php
$projectName = 'testLaravel';
$globalName = 'assembly';
$globalMaxNumberPerPage = 15;
$globalColumns = array(
    'part' => 'text',
    'car' => 'text',
    'driver' => 'text'
);


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



$globalUrl = $globalName;
$globalDatabaseName = $globalName . 's';


$globalControllerVariableName = 'ControllerPassedVar';
$globalViewFolderName = "{$projectName}/resources/views/{$globalDatabaseName}";
$globalControllerFolderName = "{$projectName}/app/Http/Controllers";
$globalModelFolderName = "{$projectName}/app/Models";




// make directory tree

if (!file_exists($globalViewFolderName)) {
    mkdir($globalViewFolderName, 0777, true);
}
if (!file_exists($globalControllerFolderName)) {
    mkdir($globalControllerFolderName, 0777, true);
}
if (!file_exists($globalModelFolderName)) {
    mkdir($globalModelFolderName, 0777, true);
}

// make create view
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

    $thisElement = <<<EOD
    <input name='{$key}' type='{$value}'>:{$key}
    <br>
    EOD;
    $output = $output . $thisElement;
}

$output2 = <<<EOD2

    <input name='submit' type='submit' value='save'>
</form>
EOD2;

$myfile = fopen("{$globalViewFolderName}/create.blade.php", "w") or die("Unable to open file!");
$txt = $output . $output2;
fwrite($myfile, $txt);
fclose($myfile);

//  make edit view
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
    $thisElement = <<<EOD
    <br>
    <input value='{{ \${$globalControllerVariableName}->{$key} }}' name='{$key}' type='{$value}'>:{$key}
    <br>
    EOD;
    $output = $output . $thisElement;
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

// Make index File

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
    $tackOn = '<th>' . strtoupper($key) . '</th>';
    $output = $output . $tackOn;
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
    $thisLIneItem = "<td>{{ \$line->{$key} }} </td>";
    $output = $output . $thisLIneItem;
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

// Make model file

$output = <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$globalDatabaseName} extends Model
{
    use HasFactory;
}
EOD;
$myfile = fopen("{$globalModelFolderName}/{$globalDatabaseName}.php", "w") or die("Unable to open file!");
$txt = $output;
fwrite($myfile, $txt);
fclose($myfile);

// make controller file

$output = <<<EDO
<?php

namespace App\Http\Controllers;

use App\Models\{$globalDatabaseName};
use Illuminate\Http\Request;

class {$globalDatabaseName}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    $thisRow = <<<EDO
    \t
    \${$globalDatabaseName}->{$key} = \$request->input('{$key}'); \n
    EDO;
    $output = $output . $thisRow;
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
        \$thisSinglesRow = $globalDatabaseName::find(\$id);
        return view('{$globalDatabaseName}.edit', ['{$globalControllerVariableName}' => \$thisSinglesRow]);
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
    $thisRow = <<<EDO
    \${$globalControllerVariableName}->{$key} = \$request->input('{$key}'); \n
    EDO;
    $output2 = $output2 . $thisRow;
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
$txt = $output . $output2 . $output3;
fwrite($myfile, $txt);
fclose($myfile);

















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
Route::resource('{$globalUrl}', {$globalDatabaseName}Controller::class);
</div>
EDO;

echo $output;