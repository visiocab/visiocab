<?php
mysql_connect('localhost','root','');
mysql_select_db('lmsdb');
##mysql_query('');

#$scores = $xml->xpath('//competition/*/stat-group/key[.="game-stats"]/../stat[@type="points"]/@num');
$start = microtime(true);
$infile = 'quiz.xml';

$x = file_get_contents($infile);

$x = preg_replace('/’/', "'", $x);

$end = microtime(true);
print "got file in ".($end - $start)." seconds \n";

$xml = new SimpleXMLElement($x);


$mquestions = $xml->xpath('//quiz/question[@type="multichoice"]');

foreach ($mquestions as $k=>$v) {
	print "<li>".$v->{'questiontext'}->{'text'};
	$qry = "INSERT INTO question SET quiz_id = 1, qtext = '".$v->{'questiontext'}->{'text'}."', qtype = 'multichoice', date_added = NOW()";
	#mysql_query($qry);
	$qid = mysql_insert_id();
	print "<ul>";
	$ord = 1;
	foreach ($v->{'answer'} as $ans) {
		print "<li>".$ans->{'text'};
		print "&nbsp;(".$ans['fraction'].")";
		print "</li>";
		$qry = "INSERT INTO answer SET question_id = $qid, aorder = $ord, atext = '".$ans->{'text'}."', correct = '".$ans['fraction']."', date_added = NOW()";
		#mysql_query($qry);
		$ord++;
	}
	print "</ul>";
}

print "<hr>";

$tquestions = $xml->xpath('//quiz/question[@type="truefalse"]');

foreach ($tquestions as $k=>$v) {
	print "<li>".$v->{'questiontext'}->{'text'};
	$qry = "INSERT INTO question SET quiz_id = 1, qtext = '".$v->{'questiontext'}->{'text'}."', qtype = 'truefalse', date_added = NOW()";
	#mysql_query($qry);
	$qid = mysql_insert_id();
	print "<ul>";
	$ord = 1;
	foreach ($v->{'answer'} as $ans) {
		print "<li>".$ans->{'text'};
		print "&nbsp;(".$ans['fraction'].")";
		print "</li>";
		$qry = "INSERT INTO answer SET question_id = $qid, aorder = $ord, atext = '".$ans->{'text'}."', correct = '".$ans['fraction']."', date_added = NOW()";
		#mysql_query($qry);
		$ord++;
	}
	print "</ul>";
}


print "<pre>";
print_r($tquestions);
print "</pre>";
?>
