<?php
$csv_output = "Id,Job Title,Name,Email,Phone,Street,City,State,Zip,Country";
 
$csv_output .= "\n";

$i=1;
foreach($jobsdata as $job):
$csv_output .="\"". $i."\", ".$job[a]['name'].",\" ".$job[b]['jrname']."\",\" ".$job[b]['email']."\",\" ".$job[b]['phone']."\",\" ".$job[b]['street']."\",\" ".$job[b]['city']."\",\" ".$job[b]['state']."\",\" ".$job[b]['zip']."\",\" ".$job[b]['country']."\"";
 
$csv_output .= "\n";
 $i++;
endforeach;
$filename = "jobapplicantslist_".date("Y-m-d");
 
header("Content-type: application/vnd.ms-excel");
 
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
 
header( "Content-disposition: filename=".$filename.".csv");
 
print $csv_output;
 
exit;
 
?>
