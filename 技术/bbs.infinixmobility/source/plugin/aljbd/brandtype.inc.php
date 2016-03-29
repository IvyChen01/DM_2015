<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$pluginid='aljbd';
include template('aljbd:type_nav');
if($_GET['lj']=='noticetype'){
	$act = $_GET['act'];
	if($act == 'del') {
		$tid = intval($_GET['tid']);
		if($tid) {
			$upcid = C::t('#aljbd#aljbd_type_notice')->fetch_upid_by_id($tid);
			if($upcid) {
				$subid = C::t('#aljbd#aljbd_type_notice')->fetch_subid_by_id($upcid);
				$subarr = explode(",", $subid);
				foreach($subarr as $key=>$value) {
					if($value == $tid) {
						unset($subarr[$key]);
						break;
					}
				}
				C::t('#aljbd#aljbd_type_notice')->update($upcid,array('subid'=>implode(",", $subarr)));
			}
			C::t('#aljbd#aljbd_type_notice')->delete($tid);
		}
		cpmsg(lang('plugin/aljbd','s1'), 'action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=noticetype', 'succeed');	
	}

	if(!submitcheck('editsubmit')) {	

	?>
	<script type="text/JavaScript">
	var rowtypedata = [
		[[1,'<input type="text" class="txt" name="newcatorder[]" value="0" />', 'td25'], [2, '<input name="newcat[]" value="" size="20" type="text" class="txt" />']],
		[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsubcat[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
		
		];

	function del(id) {
		if(confirm('<?php echo lang('plugin/brand', 'del_confirm');?>')) {
			window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=noticetype&act=del&tid='+id;
		} else {
			return false;
		}
	}
	</script>
	<?php
		showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=noticetype');
		showtableheader('');
		showsubtitle(array(lang('plugin/aljbd','s2'),lang('plugin/aljbd','s3'),  lang('plugin/aljbd','s4')));

		$brandtype = C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid(0);
		foreach($brandtype as $key=>$value){

			$bt = C::t('#aljbd#aljbd_type_notice')->fetch_all_by_upid($key);
			foreach($bt as $k=>$v){
				$brandtype[$key]['subtype'][$k] = $v;
			}
		}
		if($brandtype) {
			foreach($brandtype as $id=>$type) {
				$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"></div></td>';
				if(!$type['subid']) {
					$show .= '<td><a  onclick="del('.$id.')" href="###">'.lang('plugin/aljbd','s5').'</td></tr>';
				} else {
					$show .= '<td>&nbsp;</td></tr>';
				}
				echo $show;
				if($type['subtype']) {
					foreach($type['subtype'] as $subid=>$stype) {
						echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$stype['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$stype['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.lang('plugin/aljbd','s6').'</td></tr>';
					}
					
				}
				echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/aljbd','s7').'</a></div></td></tr>';
			}	
		}
		echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/aljbd','s8').'</a></div></td></tr>';
		

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
				C::t('#aljbd#aljbd_type_notice')->update($id,array('displayorder'=>$value,'subject'=>$name[$id]));
			}
		}

		if(is_array($newcat)) {
			foreach($newcat as $key=>$name) {
				if(empty($name)) {
					continue;
				}
				$cid=C::t('#aljbd#aljbd_type_notice')->insert(array('upid' => '0', 'subject' => $name, 'displayorder' => $newcatorder[$key]),1);
			}
		}

		if(is_array($newsubcat)) {
			foreach($newsubcat as $cid=>$subcat) {
				$sub=C::t('#aljbd#aljbd_type_notice')->fetch($cid);
				$subtype =$sub['subid'];
				foreach($subcat as $key=>$name) {
					$subid=C::t('#aljbd#aljbd_type_notice')->insert(array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]),1);
					$subtype .= $subtype ? ','.$subid : $subid;
				}
				C::t('#aljbd#aljbd_type_notice')->update($cid,array('subid'=>$subtype));
			}
		}

		cpmsg(lang('plugin/aljbd','s9'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=noticetype', 'succeed');	
	}
}else if($_GET['lj']=='consumetype'){
	$act = $_GET['act'];
	if($act == 'del') {
		$tid = intval($_GET['tid']);
		if($tid) {
			$upcid = C::t('#aljbd#aljbd_type_consume')->fetch_upid_by_id($tid);
			if($upcid) {
				$subid = C::t('#aljbd#aljbd_type_consume')->fetch_subid_by_id($upcid);
				$subarr = explode(",", $subid);
				foreach($subarr as $key=>$value) {
					if($value == $tid) {
						unset($subarr[$key]);
						break;
					}
				}
				C::t('#aljbd#aljbd_type_consume')->update($upcid,array('subid'=>implode(",", $subarr)));
			}
			C::t('#aljbd#aljbd_type_consume')->delete($tid);
		}
		cpmsg(lang('plugin/aljbd','s1'), 'action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=consumetype', 'succeed');	
	}

	if(!submitcheck('editsubmit')) {	

	?>
	<script type="text/JavaScript">
	var rowtypedata = [
		[[1,'<input type="text" class="txt" name="newcatorder[]" value="0" />', 'td25'], [2, '<input name="newcat[]" value="" size="20" type="text" class="txt" />']],
		[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsubcat[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
		
		];

	function del(id) {
		if(confirm('<?php echo lang('plugin/brand', 'del_confirm');?>')) {
			window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=consumetype&act=del&tid='+id;
		} else {
			return false;
		}
	}
	</script>
	<?php
		showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=consumetype');
		showtableheader('');
		showsubtitle(array(lang('plugin/aljbd','s2'),lang('plugin/aljbd','s3'),  lang('plugin/aljbd','s4')));

		$brandtype = C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid(0);
		foreach($brandtype as $key=>$value){

			$bt = C::t('#aljbd#aljbd_type_consume')->fetch_all_by_upid($key);
			foreach($bt as $k=>$v){
				$brandtype[$key]['subtype'][$k] = $v;
			}
		}
		if($brandtype) {
			foreach($brandtype as $id=>$type) {
				$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"></div></td>';
				if(!$type['subid']) {
					$show .= '<td><a  onclick="del('.$id.')" href="###">'.lang('plugin/aljbd','s5').'</td></tr>';
				} else {
					$show .= '<td>&nbsp;</td></tr>';
				}
				echo $show;
				if($type['subtype']) {
					foreach($type['subtype'] as $subid=>$stype) {
						echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$stype['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$stype['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.lang('plugin/aljbd','s6').'</td></tr>';
					}
					
				}
				echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/aljbd','s7').'</a></div></td></tr>';
			}	
		}
		echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/aljbd','s8').'</a></div></td></tr>';
		

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
				C::t('#aljbd#aljbd_type_consume')->update($id,array('displayorder'=>$value,'subject'=>$name[$id]));
			}
		}

		if(is_array($newcat)) {
			foreach($newcat as $key=>$name) {
				if(empty($name)) {
					continue;
				}
				$cid=C::t('#aljbd#aljbd_type_consume')->insert(array('upid' => '0', 'subject' => $name, 'displayorder' => $newcatorder[$key]),1);
			}
		}

		if(is_array($newsubcat)) {
			foreach($newsubcat as $cid=>$subcat) {
				$sub=C::t('#aljbd#aljbd_type_consume')->fetch($cid);
				$subtype =$sub['subid'];
				foreach($subcat as $key=>$name) {
					$subid=C::t('#aljbd#aljbd_type_consume')->insert(array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]),1);
					$subtype .= $subtype ? ','.$subid : $subid;
				}
				C::t('#aljbd#aljbd_type_consume')->update($cid,array('subid'=>$subtype));
			}
		}

		cpmsg(lang('plugin/aljbd','s9'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=consumetype', 'succeed');	
	}
}else if($_GET['lj']=='goodstype'){
	$act = $_GET['act'];
	if($act == 'del') {
		$tid = intval($_GET['tid']);
		if($tid) {
			$upcid = C::t('#aljbd#aljbd_type_goods')->fetch_upid_by_id($tid);
			if($upcid) {
				$subid = C::t('#aljbd#aljbd_type_goods')->fetch_subid_by_id($upcid);
				$subarr = explode(",", $subid);
				foreach($subarr as $key=>$value) {
					if($value == $tid) {
						unset($subarr[$key]);
						break;
					}
				}
				C::t('#aljbd#aljbd_type_goods')->update($upcid,array('subid'=>implode(",", $subarr)));
			}
			C::t('#aljbd#aljbd_type_goods')->delete($tid);
		}
		cpmsg(lang('plugin/aljbd','s1'), 'action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=goodstype', 'succeed');	
	}

	if(!submitcheck('editsubmit')) {	

	?>
	<script type="text/JavaScript">
	var rowtypedata = [
		[[1,'<input type="text" class="txt" name="newcatorder[]" value="0" />', 'td25'], [2, '<input name="newcat[]" value="" size="20" type="text" class="txt" />']],
		[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsubcat[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
		
		];

	function del(id) {
		if(confirm('<?php echo lang('plugin/brand', 'del_confirm');?>')) {
			window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljbd&pmod=brandtype&lj=goodstype&act=del&tid='+id;
		} else {
			return false;
		}
	}
	</script>
	<?php
		showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=goodstype');
		showtableheader('');
		showsubtitle(array(lang('plugin/aljbd','s2'),lang('plugin/aljbd','s3'),  lang('plugin/aljbd','s4')));

		$brandtype = C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid(0);
		foreach($brandtype as $key=>$value){

			$bt = C::t('#aljbd#aljbd_type_goods')->fetch_all_by_upid($key);
			foreach($bt as $k=>$v){
				$brandtype[$key]['subtype'][$k] = $v;
			}
		}
		if($brandtype) {
			foreach($brandtype as $id=>$type) {
				$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"></div></td>';
				if(!$type['subid']) {
					$show .= '<td><a  onclick="del('.$id.')" href="###">'.lang('plugin/aljbd','s5').'</td></tr>';
				} else {
					$show .= '<td>&nbsp;</td></tr>';
				}
				echo $show;
				if($type['subtype']) {
					foreach($type['subtype'] as $subid=>$stype) {
						echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$stype['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$stype['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.lang('plugin/aljbd','s6').'</td></tr>';
					}
					
				}
				echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/aljbd','s7').'</a></div></td></tr>';
			}	
		}
		echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/aljbd','s8').'</a></div></td></tr>';
		

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
				C::t('#aljbd#aljbd_type_goods')->update($id,array('displayorder'=>$value,'subject'=>$name[$id]));
			}
		}

		if(is_array($newcat)) {
			foreach($newcat as $key=>$name) {
				if(empty($name)) {
					continue;
				}
				$cid=C::t('#aljbd#aljbd_type_goods')->insert(array('upid' => '0', 'subject' => $name, 'displayorder' => $newcatorder[$key]),1);
			}
		}

		if(is_array($newsubcat)) {
			foreach($newsubcat as $cid=>$subcat) {
				$sub=C::t('#aljbd#aljbd_type_goods')->fetch($cid);
				$subtype =$sub['subid'];
				foreach($subcat as $key=>$name) {
					$subid=C::t('#aljbd#aljbd_type_goods')->insert(array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]),1);
					$subtype .= $subtype ? ','.$subid : $subid;
				}
				C::t('#aljbd#aljbd_type_goods')->update($cid,array('subid'=>$subtype));
			}
		}

		cpmsg(lang('plugin/aljbd','s9'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype&lj=goodstype', 'succeed');	
	}
}else{
	$act = $_GET['act'];
	if($act == 'del') {
		$tid = intval($_GET['tid']);
		if($tid) {
			$upcid = C::t('#aljbd#aljbd_type')->fetch_upid_by_id($tid);
			if($upcid) {
				$subid = C::t('#aljbd#aljbd_type')->fetch_subid_by_id($upcid);
				$subarr = explode(",", $subid);
				foreach($subarr as $key=>$value) {
					if($value == $tid) {
						unset($subarr[$key]);
						break;
					}
				}
				C::t('#aljbd#aljbd_type')->update($upcid,array('subid'=>implode(",", $subarr)));
			}
			C::t('#aljbd#aljbd_type')->delete($tid);
		}
		cpmsg(lang('plugin/aljbd','s1'), 'action=plugins&operation=config&do=82&identifier=aljbd&pmod=brandtype', 'succeed');	
	}

	if(!submitcheck('editsubmit')) {	

	?>
	<script type="text/JavaScript">
	var rowtypedata = [
		[[1,'<input type="text" class="txt" name="newcatorder[]" value="0" />', 'td25'], [2, '<input name="newcat[]" value="" size="20" type="text" class="txt" />']],
		[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsubcat[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
		
		];

	function del(id) {
		if(confirm('<?php echo lang('plugin/brand', 'del_confirm');?>')) {
			window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=aljbd&pmod=brandtype&act=del&tid='+id;
		} else {
			return false;
		}
	}
	</script>
	<?php
		showformheader('plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype');
		showtableheader('');
		showsubtitle(array(lang('plugin/aljbd','s2'),lang('plugin/aljbd','s3'),  lang('plugin/aljbd','s4')));

		$brandtype = C::t('#aljbd#aljbd_type')->fetch_all_by_upid(0);
		foreach($brandtype as $key=>$value){

			$bt = C::t('#aljbd#aljbd_type')->fetch_all_by_upid($key);
			foreach($bt as $k=>$v){
				$brandtype[$key]['subtype'][$k] = $v;
			}
		}
		if($brandtype) {
			foreach($brandtype as $id=>$type) {
				$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$type['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$type['subject'].'"></div></td>';
				if(!$type['subid']) {
					$show .= '<td><a  onclick="del('.$id.')" href="###">'.lang('plugin/aljbd','s5').'</td></tr>';
				} else {
					$show .= '<td>&nbsp;</td></tr>';
				}
				echo $show;
				if($type['subtype']) {
					foreach($type['subtype'] as $subid=>$stype) {
						echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$stype['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$stype['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.lang('plugin/aljbd','s6').'</td></tr>';
					}
					
				}
				echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/aljbd','s7').'</a></div></td></tr>';
			}	
		}
		echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/aljbd','s8').'</a></div></td></tr>';
		

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
				C::t('#aljbd#aljbd_type')->update($id,array('displayorder'=>$value,'subject'=>$name[$id]));
			}
		}

		if(is_array($newcat)) {
			foreach($newcat as $key=>$name) {
				if(empty($name)) {
					continue;
				}
				$cid=C::t('#aljbd#aljbd_type')->insert(array('upid' => '0', 'subject' => $name, 'displayorder' => $newcatorder[$key]),1);
			}
		}

		if(is_array($newsubcat)) {
			foreach($newsubcat as $cid=>$subcat) {
				$sub=C::t('#aljbd#aljbd_type')->fetch($cid);
				$subtype =$sub['subid'];
				foreach($subcat as $key=>$name) {
					$subid=C::t('#aljbd#aljbd_type')->insert(array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]),1);
					$subtype .= $subtype ? ','.$subid : $subid;
				}
				C::t('#aljbd#aljbd_type')->update($cid,array('subid'=>$subtype));
			}
		}

		cpmsg(lang('plugin/aljbd','s9'), 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=brandtype', 'succeed');	
	}
}
?>


