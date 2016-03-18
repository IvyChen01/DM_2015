<?php
define('VIEW', true);

$_is_bind_jobnum = false;
$_click_flag = 0;
$_money = 0;
$_max_money = 0;
$_records = null;
$_jobnum = '';
$_username = '';
$_openid = '123';
$_key = '123';

$_panelIndex = isset($_GET['a']) ? $_GET['a'] : 0;
include('view/hong_bao.php');
?>
<script type="text/javascript">
var panelIndex = <?php echo $_panelIndex; ?>;

$(document).ready(function(){
	switch (panelIndex)
	{
		case 1:
			$("#enterPanel").show();
			break;
		case 2:
			$("#enterPanel").hide();
			$('#bindPanel').show();
			break;
		case 3:
			$("#enterPanel").hide();
			$('#bindSuccessPanel').show();
			break;
		case 4:
			$("#enterPanel").hide();
			$('#bindFailPanel').show();
			tipBindFail(2);
			break;
		case 5:
			$("#enterPanel").hide();
			$('#winPanel').show();
			break;
		case 6:
			$("#enterPanel").hide();
			$('#losePanel').show();
			break;
		case 7:
			$("#enterPanel").hide();
			$('#recordPanel').show();
			break;
		case 8:
			$("#enterPanel").hide();
			hongBaoTimer = setInterval(moveHongBao, timerInterval);
			$('#hongBao').show();
			break;
		default:
	}
});
</script>
