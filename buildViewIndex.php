<?php
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
        $thisLIneItem = <<<EOD
        <td>
        @php 
        if(isset( \$line->{$globalColumns[$key]['name']}->{$globalColumns[$key]['columnShown']} )){ 
            echo  \$line->{$globalColumns[$key]['name']}->{$globalColumns[$key]['columnShown']}; 
        }else{
            echo 'null';
        } 
        @endphp
        </td>";
        EOD;
        $output = $output . $thisLIneItem;
    }
}

$output3 = <<<EOD
    <td>{{ \$line->id }}</td>
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