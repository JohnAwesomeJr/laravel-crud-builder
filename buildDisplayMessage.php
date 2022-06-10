<?php
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