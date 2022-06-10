<?php
$outputController11 = <<<EDO


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
$txt = $outputController1 . $outputController2 . $outputController3 . $outputController4 . $outputController5 . $outputController6 . $outputController7 . $outputController8 . $outputController9 . $outputController10 . $outputController11;
fwrite($myfile, $txt);
fclose($myfile);