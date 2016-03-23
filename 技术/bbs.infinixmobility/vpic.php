<?php
require_once './source/class/class_core.php';
$discuz = & discuz_core::instance();
$discuz->init();
list($w,$h)=explode("x",$_GET['size']);
$m=0;
if($w==0&&$h==0){
	$m=5;
}elseif ($h==0){
	$m=3;
}elseif ($w==0){
	$m=4;
}
/*
$w=100;//宽度
$h=75;//高度
$m=0;//缩略图模式
	//mode=0为固定宽高，画质裁切不变形
	//mode=1为固定宽高，画质会拉伸变形
	//mode=2为可变宽高，宽高不超过指定大小
	//mode=3为固定宽度，高度随比例变化
*/

$nopic='./static/image/common/nophotosmall.gif';//缺省图片
$url=$_GET['url'];
$md5=md5($url);
if(1){
$dir="data/videopic/";
$subdir=$dir."/{$w}x{$h}x{$m}/";
$thumbfile=$subdir."/{$md5[0]}{$md5[1]}/".$md5.".jpg";
if(file_exists($thumbfile)){
	header("location:{$thumbfile}");
	die();
}

$attachfile="$dir/org/{$md5[0]}{$md5[1]}/$md5.jpg";

if($m==5){
		header("location:{$attachfile}");
		die();
}
if(1){
	//$attachurl=$attach['remote']?$_G['setting']['ftp']['attachurl']:$_G['setting']['attachurl'];
	//$attachfile=$attachurl."/forum/".$attach['attachment'];
	

	if(!is_dir($dir)) @mkdir($dir);
	if(!is_dir($subdir)) @mkdir($subdir);
	if(!is_dir($subdir."/{$md5[0]}{$md5[1]}/")){
		@mkdir($subdir."/{$md5[0]}{$md5[1]}/");
	}
	if(!is_dir("$dir/org/")) @mkdir("$dir/org/");
	if(!is_dir("$dir/org/{$md5[0]}{$md5[1]}/")) @mkdir("$dir/org/{$md5[0]}{$md5[1]}/");
	//echo $url;
	$rs=parseflv_big($url);
	//print_r($rs);
	$pic=$rs['imgurl'];
	//echo "<br>".$pic;
	savefile($pic,$attachfile);
	//echo "<br>".$attachfile;
	dzthumb($attachfile,$thumbfile,$w,$h,$m);
	//echo "<br>".$thumbfile;
	//die();
	if(file_exists($thumbfile)){
		header("location:{$thumbfile}");
	}else{
		header("location:{$nopic}");
	}
	die();
}else{
	header("location:$nopic");
	die();
}
}




function dzthumb($srcfile,$dstfile,$dstw,$dsth=0,$mode=0,$data=''){
	//mode=0为固定宽高，画质裁切不变形
	//mode=1为固定宽高，画质会拉伸变形
	//mode=2为可变宽高，宽高不超过指定大小
	//mode=3为固定宽度，高度随比例变化
	$data=$data==''?@GetImageSize($srcfile):$data;
	if(!$data) return false;
	if($data[2]==2) $im=@ImageCreateFromJPEG($srcfile);
	elseif ($data[2]==1) $im=@ImageCreateFromGIF($srcfile);
	elseif($data[2]==3) $im=@ImageCreateFromPNG($srcfile);
	list($img_w, $img_h) = $data;
	if($dsth==0) $mode=3;
	if($mode==0){
		$imgratio = $img_w / $img_h;
		$thumbratio = $dstw / $dsth;
		if($imgratio >= 1 && $imgratio >= $thumbratio || $imgratio < 1 && $imgratio > $thumbratio) {
			$cuty = $img_h;
			$cutx = $cuty * $thumbratio;
		} elseif($imgratio >= 1 && $imgratio <= $thumbratio || $imgratio < 1 && $imgratio < $thumbratio) {
			$cutx = $img_w;
			$cuty = $cutx / $thumbratio;
		}
		$cx = $cutx;
		$cy = $cuty;
	}elseif($mode==1){
		$cx = $img_w;
		$cy = $img_h;
	}elseif ($mode==2){
		$cx = $img_w;
		$cy = $img_h;
		$bit=$img_w/$img_h;
		if($dstw/$dsth>$bit){
			$dstw=($img_w/$img_h)*$dsth;
		}else{
			$dsth=($img_h/$img_w)*$dstw;
		}
	}
	elseif($mode==3){
		$cx = $img_w;
		$cy = $img_h;
		$dsth=$dstw * $img_h / $img_w;
	}
	elseif ($mode==4){
		$cx = $img_w;
		$cy = $img_h;
		$dstw=$dsth * $img_w / $img_h;
	}
	$ni=imagecreatetruecolor($dstw,$dsth);
	ImageCopyResampled($ni,$im,0,0,0,0,$dstw,$dsth, $cx, $cy);
	clearstatcache();
	if($data[2]==2) ImageJPEG($ni,$dstfile,100);
	elseif($data[2]==1) ImageGif($ni,$dstfile);
	elseif($data[2]==3) ImagePNG($ni,$dstfile);
	return true;
}
function xdfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;

	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

function savefile($src,$target){
	if(file_exists($target)){
		
	}
	elseif(@copy($src,$target)){

	}elseif ($content=@file_get_contents($src)){
		$fp=@fopen($target,"w");
		@fwrite($fp,$content);
		@fclose($fp);
	}elseif ($content=@xdfopen($src)){
		$fp=@fopen($target,"w");
		@fwrite($fp,$content);
		@fclose($fp);
	}
	
	$sizeinfo=@getimagesize($target);
	if(!$sizeinfo[0]||!$sizeinfo[2]){
		//@unlink($target);
		return false;
	}else{
		return $sizeinfo[0];
	}
	return false;
}
     function parseflv_big($url, $width = 0, $height = 0){
         $lowerurl = strtolower($url);
         $flv = $iframe = $imgurl = '';
         if($lowerurl != str_replace(array('player.youku.com/player.php/sid/', 'tudou.com/v/', 'player.ku6.com/refer/','player.56.com'), '', $lowerurl)){
             $flv = $url;

             if(preg_match("/youku.*\/sid\/([^\/]+)\//i", $url, $matches)) {
             	$api = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$matches[1];
             	$str = stripslashes(file_get_contents($api, false, $ctx));
             	if(!empty($str) && preg_match("/\"logo\":\"(.+?)\"/i", $str, $image)){
             		$url = substr($image[1], 0, strrpos($image[1], '/') + 1);
             		$filename = substr($image[1], strrpos($image[1], '/') + 2);
             		$imgurl = $url . '1' . $filename;
             	}
             }
             //echo $url;
             if(preg_match("/56\.com\/v_([^\/]+)\.swf/i",$url,$matches)){
             	 //echo 'xx';
             	$api = 'http://vxml.56.com/json/' . str_replace('v_', '', $matches[1]) . '/?src=out';
                 $str = file_get_contents($api, false, $ctx);
                 if(!empty($str) && preg_match("/\"bimg\":\"(.+?)\"/i", $str, $image)){
                     $imgurl = trim($image[1]);
                    }
             }
             
             

            
             
             
          }elseif(strpos($lowerurl, 'v.youku.com/v_show/') !== FALSE){
             $ctx = stream_context_create(array('http' => array('timeout' => 10)));
             if(preg_match("/http:\/\/v.youku.com\/v_show\/id_([^\/]+)(.html|)/i", $url, $matches)){
                 $flv = 'http://player.youku.com/player.php/sid/' . $matches[1] . '/v.swf';
                 $iframe = 'http://player.youku.com/embed/' . $matches[1];
                 if(!$width && !$height){
                     $api = 'http://v.youku.com/player/getPlayList/VideoIDS/' . $matches[1];
                     $str = stripslashes(file_get_contents($api, false, $ctx));
                     if(!empty($str) && preg_match("/\"logo\":\"(.+?)\"/i", $str, $image)){
                         $url = substr($image[1], 0, strrpos($image[1], '/') + 1);
                         $filename = substr($image[1], strrpos($image[1], '/') + 2);
                         $imgurl = $url . '1' . $filename;
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'tudou.com/programs/view/') !== FALSE){
             if(preg_match("/http:\/\/(www.)?tudou.com\/programs\/view\/([^\/]+)/i", $url, $matches)){
                 $flv = 'http://www.tudou.com/v/' . $matches[2];
                 $iframe = 'http://www.tudou.com/programs/view/html5embed.action?code=' . $matches[2];
                 if(!$width && !$height){
                     $str = file_get_contents($url, false, $ctx);
                     if(!empty($str) && preg_match("/<span class=\"s_pic\">(.+?)<\/span>/i", $str, $image)){
                         $imgurl = trim($image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'v.ku6.com/show/') !== FALSE){
             if(preg_match("/http:\/\/v.ku6.com\/show\/([^\/]+).html/i", $url, $matches)){
                 $flv = 'http://player.ku6.com/refer/' . $matches[1] . '/v.swf';
                 if(!$width && !$height){
                     $api = 'http://vo.ku6.com/fetchVideo4Player/1/' . $matches[1] . '.html';
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str) && preg_match("/\"bigpicpath\":\"(.+?)\"/i", $str, $image)){
                         $imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'v.ku6.com/special/show_') !== FALSE){
             if(preg_match("/http:\/\/v.ku6.com\/special\/show_\d+\/([^\/]+).html/i", $url, $matches)){
                 $flv = 'http://player.ku6.com/refer/' . $matches[1] . '/v.swf';
                 if(!$width && !$height){
                     $api = 'http://vo.ku6.com/fetchVideo4Player/1/' . $matches[1] . '.html';
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str) && preg_match("/\"bigpicpath\":\"(.+?)\"/i", $str, $image)){
                         $imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'v.ku6.com/film/show_') !== FALSE){
             if(preg_match("/http:\/\/v.ku6.com\/film\/show_\d+\/([^\/]+).html/i", $url, $matches)){
                 $flv = 'http://player.ku6.com/refer/' . $matches[1] . '/v.swf';
                 if(!$width && !$height){
                     $api = 'http://vo.ku6.com/fetchVideo4Player/1/' . $matches[1] . '.html';
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str) && preg_match("/\"bigpicpath\":\"(.+?)\"/i", $str, $image)){
                         $imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'www.youtube.com/watch?') !== FALSE){
             if(preg_match("/http:\/\/www.youtube.com\/watch\?v=([^\/&]+)&?/i", $url, $matches)){
                 $flv = 'http://www.youtube.com/v/' . $matches[1] . '&hl=zh_CN&fs=1';
                 $iframe = 'http://www.youtube.com/embed/' . $matches[1];
                 if(!$width && !$height){
                     $str = file_get_contents($url, false, $ctx);
                     if(!empty($str) && preg_match("/'VIDEO_HQ_THUMB':\s'(.+?)'/i", $str, $image)){
                         $url = substr($image[1], 0, strrpos($image[1], '/') + 1);
                         $filename = substr($image[1], strrpos($image[1], '/') + 3);
                         $imgurl = $url . $filename;
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'tv.mofile.com/') !== FALSE){
             if(preg_match("/http:\/\/tv.mofile.com\/([^\/]+)/i", $url, $matches)){
                 $flv = 'http://tv.mofile.com/cn/xplayer.swf?v=' . $matches[1];
                 if(!$width && !$height){
                     $str = file_get_contents($url, false, $ctx);
                     if(!empty($str) && preg_match("/thumbpath=\"(.+?)\";/i", $str, $image)){
                         $imgurl = trim($image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'v.mofile.com/show/') !== FALSE){
             if(preg_match("/http:\/\/v.mofile.com\/show\/([^\/]+).shtml/i", $url, $matches)){
                 $flv = 'http://tv.mofile.com/cn/xplayer.swf?v=' . $matches[1];
                 if(!$width && !$height){
                     $str = file_get_contents($url, false, $ctx);
                     if(!empty($str) && preg_match("/thumbpath=\"(.+?)\";/i", $str, $image)){
                         $imgurl = trim($image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'video.sina.com.cn/v/b/') !== FALSE){
             if(preg_match("/http:\/\/video.sina.com.cn\/v\/b\/(\d+)-(\d+).html/i", $url, $matches)){
                 $flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid=' . $matches[1];
                 if(!$width && !$height){
                     $api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid=' . $matches[1];
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str)){
                         $imgurl = str_replace('imgurl=', '', trim($str));
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'you.video.sina.com.cn/b/') !== FALSE){
             if(preg_match("/http:\/\/you.video.sina.com.cn\/b\/(\d+)-(\d+).html/i", $url, $matches)){
                 $flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid=' . $matches[1];
                 if(!$width && !$height){
                     $api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid=' . $matches[1];
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str)){
                         $imgurl = str_replace('imgurl=', '', trim($str));
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'http://my.tv.sohu.com/u/') !== FALSE){
             if(preg_match("/http:\/\/my.tv.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)){
                 $flv = 'http://v.blog.sohu.com/fo/v4/' . $matches[1];
                 if(!$width && !$height){
                     $api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id=' . $matches[1] . '&outType=3';
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)){
                         $imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'http://v.blog.sohu.com/u/') !== FALSE){
             if(preg_match("/http:\/\/v.blog.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)){
                 $flv = 'http://v.blog.sohu.com/fo/v4/' . $matches[1];
                 if(!$width && !$height){
                     $api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id=' . $matches[1] . '&outType=3';
                     $str = file_get_contents($api, false, $ctx);
                     if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)){
                         $imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
                         }
                     }
                 }
             }elseif(strpos($lowerurl, 'http://www.ouou.com/fun_funview') !== FALSE){
             $str = file_get_contents($url, false, $ctx);
             if(!empty($str) && preg_match("/var\sflv\s=\s'(.+?)';/i", $str, $matches)){
                 $flv = $_G['style']['imgdir'] . '/flvplayer.swf?&autostart=true&file=' . urlencode($matches[1]);
                 if(!$width && !$height && preg_match("/var\simga=\s'(.+?)';/i", $str, $image)){
                     $imgurl = trim($image[1]);
                     }
                 }
             }elseif(strpos($lowerurl, 'http://www.56.com') !== FALSE){
            
             if(preg_match("/http:\/\/www.56.com\/\S+\/play_album-aid-(\d+)_vid-(.+?).html/i", $url, $matches)){
                 $flv = 'http://player.56.com/v_' . $matches[2] . '.swf';
                 $matches[1] = $matches[2];
                 }elseif(preg_match("/http:\/\/www.56.com\/\S+\/([^\/]+).html/i", $url, $matches)){
                 $flv = 'http://player.56.com/' . $matches[1] . '.swf';
                 }
             if(!$width && !$height && !empty($matches[1])){
                 $api = 'http://vxml.56.com/json/' . str_replace('v_', '', $matches[1]) . '/?src=out';
                 $str = file_get_contents($api, false, $ctx);
                 if(!empty($str) && preg_match("/\"bimg\":\"(.+?)\"/i", $str, $image)){
                     $imgurl = trim($image[1]);
                     }
                 }
             }
         if($flv){
               return array('flv' => $flv, 'imgurl' => $imgurl);
             }else{
             return FALSE;
             }
        }

?>