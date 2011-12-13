<?php
    header('content-type: text/xml');
	header('content-disposition: attachment; filename=data_export.xml');
	include('export.php');
?>