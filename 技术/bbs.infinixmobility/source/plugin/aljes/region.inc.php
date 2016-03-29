<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$act = $_GET['act'];
if($act == 'del') {
	$tid = intval($_GET['tid']);
	if($tid) {
		$upcid = C::t('#aljes#aljes_region')->fetch_upid_by_id($tid);
		if($upcid) {
			$subid = C::t('#aljes#aljes_region')->fetch_subid_by_id($upcid);
			$subarr = explode(",", $subid);
			foreach($subarr as $key=>$value) {
				if($value == $tid) {
					unset($subarr[$key]);
					break;
				}
			}
			C::t('#aljes#aljes_region')->update($upcid,array('subid'=>implode(",", $subarr)));
		}
		C::t('#aljes#aljes_region')->delete($tid);
	}
	cpmsg(lang('plugin/aljes','aljes_7'), 'action=plugins&operation=config&do=82&identifier=aljes&pmod=region', 'succeed');	
}

if(!submitcheck('editsubmit')) {	

?>
<script type="text/JavaScript">
var rowtypedata = [
	[[1,'<input type="text" class="txt" name="newcatorder[]" value="0" />', 'td25'], [2, '<input name="newcat[]" value="" size="20" type="text" class="txt" />']],
	[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsubcat[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
	
	];

function del(id) {
	if(confirm('<?php echo lang('plugin/aljes','region_1');?>')) {
		window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljes&pmod=region&act=del&tid='+id;
	} else {
		return false;
	}
}
</script>
<?php
	showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljes&pmod=region');
	showtableheader('');
	showsubtitle(array(lang('plugin/aljes','region_2'),lang('plugin/aljes','region_3'),lang('plugin/aljes','region_4')));

	$region = C::t('#aljes#aljes_region')->fetch_all_by_upid(0);
	foreach($region as $key=>$value){

		$bt = C::t('#aljes#aljes_region')->fetch_all_by_upid($key);
		foreach($bt as $k=>$v){
			$region[$key]['subtype'][$k] = $v;
		}
	}
	if($region) {
		foreach($region as $id=>$type) {
			$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"></div></td>';
			if(!$type['subid']) {
				$show .= '<td><a  onclick="del('.$id.')" href="###">'.lang('plugin/aljes','region_5').'</td></tr>';
			} else {
				$show .= '<td>&nbsp;</td></tr>';
			}
			echo $show;
			if($type['subtype']) {
				foreach($type['subtype'] as $subid=>$stype) {
					echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$stype['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$stype['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.lang('plugin/aljes','region_5').'</td></tr>';
				}
				
			}
			echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/aljes','region_8').'</a></div></td></tr>';
		}	
	}
	echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/aljes','region_6').'</a></div></td></tr>';
	

	showsubmit('editsubmit');
	showtablefooter();
	showformfooter();

} else {
	$order = $_GET['order'];
	$name = $_GET['name'];
	$newsubcat = $_GET['newsubcat'];
	$newcat = $_GET['newcat'];
	$newsuborder = $_GET['newsuborder'];
	$newcatorder = $_GET['newcatorder'];
	if(is_array($order)) {
		foreach($order as $id=>$value) {
			C::t('#aljes#aljes_region')->update($id,array('displayorder'=>$value,'subject'=>$name[$id]));
		}
	}

	if(is_array($newcat)) {
		foreach($newcat as $key=>$name) {
			if(empty($name)) {
				continue;
			}
			$cid=C::t('#aljes#aljes_region')->insert(array('upid' => '0', 'subject' => $name, 'displayorder' => $newcatorder[$key]),1);
		}
	}

	if(is_array($newsubcat)) {
		foreach($newsubcat as $cid=>$subcat) {
			$sub=C::t('#aljes#aljes_region')->fetch($cid);
			$subtype =$sub['subid'];
			foreach($subcat as $key=>$name) {
				$subid=C::t('#aljes#aljes_region')->insert(array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]),1);
				$subtype .= $subtype ? ','.$subid : $subid;
			}
			C::t('#aljes#aljes_region')->update($cid,array('subid'=>$subtype));
		}
	}

	cpmsg(lang('plugin/aljes','region_7'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljes&pmod=region', 'succeed');	
}

?>


