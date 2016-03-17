/**
 * Created by rrr on 14-6-17.
 */
function turntable(luckyCode){
    var code = 0;
    var fixLucky = [0, 5, 1, 3, 7, 6, 2];
    if (luckyCode >= 0 && luckyCode <= 6)
    {
        code = fixLucky[luckyCode];
    }
    var startDeg=360/16;
    startDeg+=2160+(~~code-1)*360/8;
	try
	{
		["Moz","0","Webkit","ms",""].forEach(function(brower){
			document.querySelector(".turntable").style[brower+"TransitionDuration"]="5s";
			document.querySelector(".turntable").style[brower+"Transform"]="rotate("+startDeg+"deg)";
		});
		setTimeout(function(){
			["Moz","0","Webkit","ms",""].forEach(function(brower){
				document.querySelector(".turntable").style[brower+"TransitionDuration"]="0s";
				document.querySelector(".turntable").style[brower+"Transform"]="rotate("+(startDeg-2160)+"deg)";
			});
		showTip(luckyCode);
		},5100)
	}
	catch (e)
	{
	}
}

function showTip(code)
{
    var lucky = ["蓝牙耳机","充电宝","果冻表","三折伞","压缩毛巾","拍拍手环"];
    if(0<code&&code<7){
        var lackName=lucky[code-1];
        document.querySelector(".prize-name").innerHTML=lackName;
    }
    else{
        document.querySelector(".lot-result .title").innerHTML="亲，下次再来吧！！！";
        document.querySelector(".prize").style.display="none";
    }
    document.querySelector(".lot-result").style.display="block";

}