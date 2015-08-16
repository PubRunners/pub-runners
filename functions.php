<?php
function escape($conn,$values) 
{ 
 if(is_array($values))
 { 
 $values = array_map(array(&$this, 'escape'), $values); 
 } 
 else 
 { 
 /* Quote if not integer */ 
	if ( !is_numeric($values) || $values{0} == '0' ) 
	{ 
		$values = "'" .mysqli_real_escape_string($conn,$values) . "'"; 
	}
	if (is_numeric($values))
	{
	intval($values);
	}
 } 
 return $values; 
 }
?>