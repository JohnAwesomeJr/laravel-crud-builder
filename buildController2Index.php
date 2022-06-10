<?php
$outputController3 = <<<EDO
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
EDO;