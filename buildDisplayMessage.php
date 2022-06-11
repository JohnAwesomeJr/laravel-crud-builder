<?php
$controllerNameJoined = $globalDatabaseName . 'Controller';
$output = <<<EDO
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<div class="centering">
<div class="card">
  <div class="card-header">
  <h1>One More Step!</h1>
  </div>
  <div class="card-body">
  <p>Please copy and paste the code below and place it in the <span style="background:lightgray; color:darkblue; padding:5px 10px; border-radius:3px;">web.php</span> Routes file. <br></p>
  <div class="alert alert-warning">
  use App\Http\Controllers\{$controllerNameJoined};
  <br>
  Route::resource('{$globalUrl}', {$globalDatabaseName}Controller::class);
  </div>
  </div>
</div>
</div>
// testing this was added by feature c
this was added by feature b
<style>
.card{
max-width:900px;
}
.centering{
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: stretch;
    align-items: center;
    height:100vh;
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