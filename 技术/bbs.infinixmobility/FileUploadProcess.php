<?php
function get_avatar($uid, $size = 'middle', $type = '') {
        $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
        $uid = abs(intval($uid));
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        $typeadd = $type == 'real' ? '_real' : '';
        return $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
}
function get_avatar_dir($uid, $size = 'middle', $type = '') {
        $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
        $uid = abs(intval($uid));
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        $typeadd = $type == 'real' ? '_real' : '';
        return $dir1.'/'.$dir2.'/'.$dir3.'/';
}
$uid = isset($_POST['uid']) ? $_POST['uid'] : 0;
$size = isset($_POST['size']) ? $_POST['size'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$doc_path=$_SERVER['DOCUMENT_ROOT'];
$avatar_dir = './uc_server/data/avatar/'.get_avatar_dir($uid, $size, $type);
if(!is_dir($avatar_dir)){//不存在该目录，则创建
			mkdir($avatar_dir,0755,true);
		}
$avatar = './uc_server/data/avatar/'.get_avatar($uid, 'small', $type);
$avatar_middle = './uc_server/data/avatar/'.get_avatar($uid, 'middle', $type);
$avatar_big = './uc_server/data/avatar/'.get_avatar($uid, 'big', $type);
$avatar_url =  $avatar;
	/*****************文件的上传***********************/
	/**
	 * 主要解决的问题
	 * 1.上传文件的大小
	 * 2.上传文件的类型
	 * 3.不同用户上传保证图片名称相同的不被覆盖
	 * 4.同一个用户上传的图片名称相同也要保证不被覆盖
	 * 5.上传的文件超过了php.ini中upload_max_filesize选项限制的值
	 * $_FILES['upfile']['name']:客户端机器文件的原名称
	 * $_FILES['upfile']['type']:文件的MIME类型，需要浏览器提供该信息的支持
	 * $_FILES['upfile']['size']:已上传的文件的大小，单位为字节
	 * $_FILES['upfile']['tmp_name']:文件被上传之后在服务器端存储的临时文件名
	 * $_FILES['upfile']['error']:伴随文件上传时产生的错误代码
	 */
	//判断上传的文件是否存在
	if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
		if($_FILES['myfile']['size'] > 2*1024*1024){
echo "<script type='javascript/text'>alert('文件过大，不能上传文件大于2M的文件！');</script>";			
		}
		if($_FILES['myfile']['type']!='image/jpeg' 
				 && $_FILES['myfile']['type']!='image/png'
				 &&  $_FILES['myfile']['type']!='image/gif'
				 &&  $_FILES['myfile']['type']!='image/bmp'){
echo "<script type='javascript/text'>alert('只能够上传文件类型为jpg、png、gif、bmp格式的图片');</script>";		
		}
		$file_name=$avatar_url;//文件名称
		if(move_uploaded_file($_FILES['myfile']['tmp_name'], $file_name)){
			if(copy($file_name,$avatar_middle) && copy($file_name,$avatar_big)){			
				echo "<script type='javascript/text'>alert('头像修改成功!');</script>";
			}else{
				echo "<script type='javascript/text'>alert('头像修改失败!');</script>";
			}
		}else{
			echo "<script type='javascript/text'>alert('头像修改失败!');</script>";
		}
	}else{
		echo "<script type='javascript/text'>alert('头像修改失败!');</script>";
	}
echo "<script language='javascript' type='text/javascript'>window.location.href='forum.php?mobile=2';</script>"; 
?>

