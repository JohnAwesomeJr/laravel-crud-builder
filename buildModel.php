<?php
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
    protected \$table = '{$globalName}';
    use HasFactory;
EOD;

foreach ($globalColumns as $key => $value) {
    if ($globalColumns[$key]['type'] == 'selectList') {
        $thisThing = <<<MIKEEDO
    public function {$globalColumns[$key]['name']}()
    {
        return \$this->belongsTo({$globalColumns[$key]['databaseName']}s::class, '{$globalColumns[$key]['IdCollumnForThisTable']}', '{$globalColumns[$key]['ForenIdColumn']}');
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