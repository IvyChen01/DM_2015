/**
 * [品牌空间] (C)2001-2010 Comsenz Inc. This is NOT a freeware, use is subject to license terms
 *
 * $Id: viewgoodspic.js 3776 2010-07-16 08:21:35Z yexinhao $
 */

jq(function() {
	jq(".goodlist li").wrapAll(document.createElement("div"));
	var total = Math.ceil((jq(".goodlist div li").size()) / 5) * 96 * 5;
	jq(".goodlist div").css( {
		position : "absolute",
		left : "0",
		width : total + "px"
	});

	if ((jq(".goodlist div li").size() <= 5))
		jq(".next").fadeTo("1", 0.25).css( {
			cursor : "default"
		});
	jq(".goodlist li").eq(0).addClass("curr_pic");
	var src_curr = jq("#tarpic").attr("src");
	jq(".goodlist li").each(function(i) {
		jq(this).click(function() {
			changepic(i);
			return false;
		});
		var src_tmp = jq(this).find("img").attr("midimg");
		if (src_tmp == src_curr) {
			jq(".goodlist li").removeClass("curr_pic");
			jq(this).addClass("curr_pic");
		}
	})
	jq(".targetpic_prev a").click(function() {
		showsibpic(1);
		return false;
	});
	jq(".targetpic_next a").click(function() {
		showsibpic(-1);
		return false;
	});
	jq(".prev a").click(function() {
		animates(1);
		return false;
	});
	jq(".next a").click(function() {
		animates(-1);
		return false;
	});
});

var state = 1;
jq(".next").click(function() {
	var total = jq(".goodlist div").css("width");
	var currentleft = parseInt(jq(".goodlist div").css("marginLeft"));
	var endpos = 480 - parseInt(total);
	if (state) {
		if (currentleft != endpos) {
			state = 0;
			animates(currentleft - 480);
		} else {
			return false;
		}
	} else {
		return false;
	}
	return false;
});
jq(".prev").click(function() {
	var currentleft = parseInt(jq(".goodlist div").css("marginLeft"));
	if (state) {
		if (currentleft >= 0) {
			return false;
		} else {
			state = 0;
			animates(currentleft + 480);
		}
	} else {
		return false;
	}
	return false;
});
function animates(n) {
	if (state == 0) {
		return false;
	}
	state = 0;
	var m_left = parseInt(jq(".goodlist div").css("left"));
	var t_width = jq(".goodlist div").width();
	if ((t_width - Math.abs(m_left)) > 480 && n == -1) {
		jq(".prev a").fadeTo("1", 1).css( {
			cursor : "pointer"
		});
		jq(".goodlist div")
				.animate(
						{
							left : (m_left - 480) + "px"
						},
						1200,
						function() {
							state = 1;
							if (Math.abs(parseInt(jq(".goodlist div")
									.css("left"))) == t_width - 480) {
								jq(".next a").fadeTo("1", 0.25).css( {
									cursor : "default"
								});
							}
							;
							var tmp = Math.abs(parseInt(jq(".goodlist div").css(
									"left"))) / 480;
							changepic(tmp * 5)
						});
	} else if (m_left < 0 && n == 1) {
		jq(".next a").fadeTo("1", 1).css( {
			cursor : "pointer"
		});
		jq(".goodlist div").animate( {
			left : (m_left + 480) + "px"
		}, 1200, function() {
			state = 1;
			if (parseInt(jq(".goodlist div").css("left")) == 0) {
				jq(".prev a").fadeTo("1", 0.25).css( {
					cursor : "default"
				});
			}
			var tmp = Math.abs(parseInt(jq(".goodlist div").css("left"))) / 480;
			changepic(tmp * 5 + 4);
		});
	} else {
		state = 1;
		return false;
	}
}

function showsibpic(n) {
	if (state == 0) {
		return false;
	}
	state = 0;
	var t;
	var i = jq(".goodlist li").index(jq('.curr_pic')[0]);
	if ((i == 0 && n == 1) || i == (jq(".goodlist li").size() - 1) && n == -1) {
		state = 1;
		return false;
	}
	if (n == -1) {
		t = i + 1;
	} else if (n == 1) {
		t = i - 1;
	}
	changepic(t);
	state = 1;
	if (((t + 1) % 5) == 0 && n == 1) {
		animates(1)
	}
	;
	if ((t % 5) == 0 && n == -1) {
		animates(-1);
	}
}

function changepic(n) {
	var imgsrc = jq(".goodlist li").eq(n).find("img").attr("midimg");// big photo
	var discription = jq(".goodlist li").eq(n).find("p").html();// photo
																// description
	jq("#tarpic").attr("src", imgsrc);
	jq(".targetpic_main").find("p").html(discription);
	jq(".goodlist li").removeClass("curr_pic");
	jq(".goodlist li").eq(n).addClass("curr_pic");
}