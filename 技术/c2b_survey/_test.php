<?php
$str = '[{"id":1,"answer":[],"fill":""},{"id":2,"answer":["0"],"fill":""},{"id":13,"answer":["1"],"fill":""},{"id":15,"answer":["1"],"fill":""}]';
$arr = json_decode($str, true);

echo get_phone_type($arr);

function get_phone_type($answer)
{
	foreach ($answer as $key => $value)
	{
		if ($value['id'] == 1)
		{
			if (is_array($value['answer']))
			{
				return $value['answer'][0];
			}
			
			return '4';
		}
	}
	
	return '4';
}
?>
