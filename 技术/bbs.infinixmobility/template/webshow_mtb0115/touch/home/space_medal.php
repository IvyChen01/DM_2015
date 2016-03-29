<?php exit;?>
<!--{template common/header}-->
<script type="text/javascript">
$().ready(function(){
$(".m_txt").html("Badge centre");
});
</script>
<div class="cc_main">
    <h2 class="h2_title">
		<!--{if $_GET[action] == 'log'}-->{lang my_medals}<!--{else}-->{lang medals_center}<!--{/if}-->
        <span><!--{if $_GET[action] == 'log'}--><a href="home.php?mod=medal">Back</a><!--{else}--><a href="home.php?mod=medal&action=log">{lang my_medals}</a><!--{/if}--></span>
    </h2>
    <div class="cc_c">
			<!--{if empty($_GET[action])}-->
				<!--{if $medallist}-->
					<ul class="mgcl cl">
						<!--{loop $medallist $key $medal}-->
							<li>
                                <dl class="cl">
                                    <dd class="dd1">
                                        <span class="s1">$medal[name]</span>
                                        <span class="s2">
											<!--{if $medal[expiration]}-->
												{lang expire} $medal[expiration] {lang days},
											<!--{/if}-->
											<!--{if $medal[permission] && !$medal['price']}-->
												$medal[permission]
											<!--{else}-->
												<!--{if $medal[type] == 0}-->
													{lang medals_type_0}
												<!--{elseif $medal[type] == 1}-->
													<!--{if $medal['price']}-->
														<!--{if {$_G['setting']['extcredits'][$medal[credit]][unit]}}-->
															{$_G['setting']['extcredits'][$medal[credit]][title]} <strong class="xi1 xw1 xs2">$medal[price]</strong> {$_G['setting']['extcredits'][$medal[credit]][unit]}
														<!--{else}-->
															<strong class="xi1 xw1 xs2">$medal[price]</strong> {$_G['setting']['extcredits'][$medal[credit]][title]}
														<!--{/if}-->
													<!--{else}-->
														{lang medals_type_1}
													<!--{/if}-->
												<!--{elseif $medal[type] == 2}-->
													{lang medals_type_2}
												<!--{/if}-->
											<!--{/if}-->
                                        </span>
                                    </dd>
								    <dd class="dd2"><img src="{STATICURL}image/common/$medal[image]" alt="$medal[name]" /></dd>
                                    <dd class="dd3">
									<!--{if in_array($medal[medalid], $membermedal)}-->
										{lang space_medal_have}
									<!--{else}-->
										<!--{if $medal[type] && $_G['uid']}-->
											<!--{if in_array($medal[medalid], $mymedals)}-->
												<!--{if $medal['price']}-->
													{lang space_medal_purchased}
												<!--{else}-->
													<!--{if !$medal[permission]}-->
														{lang space_medal_applied}
													<!--{else}-->
														{lang space_medal_receive}
													<!--{/if}-->
												<!--{/if}-->
											<!--{else}-->
												<a href="javascript:;" onclick="showWindow('medal', 'home.php?mod=medal&action=confirm&medalid=$medal[medalid]')" class="xi2">
													<!--{if $medal['price']}-->
														{lang space_medal_buy}
													<!--{else}-->
														<!--{if !$medal[permission]}-->
															{lang medals_apply}
														<!--{else}-->
															{lang medals_draw}
														<!--{/if}-->
													<!--{/if}-->
												</a>
											<!--{/if}-->
										<!--{/if}-->
									<!--{/if}-->
                                    </dd>
                                </dl>
							</li>
						<!--{/loop}-->
					</ul>
				<!--{else}-->
					<!--{if $medallogs}-->
						<p class="emp">{lang medals_nonexistence}</p>
					<!--{else}-->
						<p class="emp">{lang medals_noavailable}</p>
					<!--{/if}-->
				<!--{/if}-->

				<!--{if $lastmedals}-->
					<h2 class="h2_title h2_title_t mtop10">{lang medals_record}</h2>
					<ul class="mgcl_txt">
						<!--{loop $lastmedals $lastmedal}-->
						<li>
							<span>$lastmedalusers[$lastmedal[uid]][username]</span> {lang medals_message1} $lastmedal[dateline] {lang medals_message2} <strong>$medallist[$lastmedal['medalid']]['name']</strong> {lang medals}
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
                
			<!--{elseif $_GET[action] == 'log'}-->

				<!--{if $mymedals}-->
					<ul class="mgcl cl">
						<!--{loop $mymedals $mymedal}-->
						<li>
                            <dl>
                            <dd class="dd1">$mymedal[name]</dd>
							<dd class="dd2"><img src="{STATICURL}image/common/$mymedal[image]" alt="$mymedal[name]" /></dd>
                            </dl>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->

				<!--{if $medallogs}-->
					<h2 class="h2_title h2_title_t mtop10">{lang medals_record}</h2>
					<ul  class="mgcl_txt">
						<!--{loop $medallogs $medallog}-->
						<li>
							<!--{if $medallog['type'] == 2 || $medallog['type'] == 3}-->
								{lang medals_message3} $medallog[dateline] {lang medals_message4} <strong>$medallog[name]</strong> {lang medals},<!--{if $medallog['type'] == 2}-->{lang medals_operation_2}<!--{elseif $medallog['type'] == 3}-->{lang medals_operation_3}<!--{/if}-->
							<!--{elseif $medallog['type'] != 2 && $medallog['type'] != 3}-->
								{lang medals_message3} $medallog[dateline] {lang medals_message5} <strong>$medallog[name]</strong> {lang medals},<!--{if $medallog[expiration]}-->{lang expire}: $medallog[expiration]<!--{else}-->{lang medals_noexpire}<!--{/if}-->
							<!--{/if}-->
						</li>
						<!--{/loop}-->
					</ul>
					<!--{if $multipage}--><div class="pgs cl mtm">$multipage</div><!--{/if}-->
				<!--{else}-->
					<p class="emp">{lang medals_nonexistence_own}</p>
				<!--{/if}-->
			<!--{/if}-->
    </div>
</div>
<!--{template common/footer}-->