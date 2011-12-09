<?php
sleep(2);

// Fill [$options] with radiobutton properties now 
$options = get_options();


// Check, if we need to proccess the FORM submission (or AJAX call that pretends POST method)
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
	// veriffy user input!
	$vote = in_range($_POST['rate'], 1, 5);

	// update statistic and save to file
	$db = save_vote($vote);

	// For AJAX requests we'll return JSON object with current vote statistics
	if($_SERVER['HTTP_X_REQUESTED_WITH'])
	{
		header('Cache-Control: no-cache');
		echo json_encode($db); // requires: PHP >= 5.2.0, PECL json >= 1.2.0
	}
	// For non-AJAX requests we are going to echo {$post_message} variable in main script
	else
	{
		$avg = round($db['avg']);

		foreach($options as $id => $val) {
			$options[$id]['disabled'] = 'disabled="disabled"';
			$options[$id]['checked']  = $id==$avg ? 'checked="checked"' : '';
		}
	}
}


// ========================
// Functions
// ========================
function get_options() {
	return array(
		1 => array('title' => 'Not so great'),
		2 => array('title' => 'Quite good'),
		3 => array('title' => 'Good'),
		4 => array('title' => 'Great!'),
		5 => array('title' => 'Excellent!'),
	);
}

function in_range($val, $from=0, $to=100) {
	return min($to, max($from, (int)$val));
}

function get_dbfile() {
	return preg_replace('#\.php$#', '.dat', __FILE__);
}

function get_votes() {
	$dbfile = get_dbfile();
	return is_file($dbfile) ? unserialize(file_get_contents($dbfile)) : array('votes' => 0, 'sum' => 0, 'avg' => 0);
}

function save_vote($vote) {
	$db = get_votes();
	$db['votes']++;
	$db['sum'] += $vote;
	$db['avg'] = sprintf('%01.1f', $db['sum'] / $db['votes']);
	file_put_contents(get_dbfile(), serialize($db));

	return $db;
}
