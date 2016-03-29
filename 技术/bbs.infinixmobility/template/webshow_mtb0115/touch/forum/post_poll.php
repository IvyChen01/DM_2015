<?php exit;?>
<div>
    <input type="hidden" name="polls" value="yes" />
    <input type="hidden" name="fid" value="$_G[fid]" />

    <!--{if $_GET[action] == 'newthread'}-->
        <input type="hidden" name="tpolloption" value="2" />
        <p style="margin-right:14px;">
        <textarea name="polloptions" rows="3"  placeholder="{lang post_poll_options}: {lang post_poll_comment_s},{lang post_poll_comment}" /></textarea>
        </p>
        
    <!--{else}-->
        <!--{loop $poll['polloption'] $key $option}-->
            <p>
                <input type="hidden" name="polloptionid[{$poll[polloptionid][$key]}]" value="$poll[polloptionid][$key]" />
                <input type="text" name="displayorder[{$poll[polloptionid][$key]}]" autocomplete="off"  value="$poll[displayorder][$key]" />
                <input type="text" name="polloption[{$poll[polloptionid][$key]}]" autocomplete="off" style="width:290px;"  value="$option"{if !$_G['group']['alloweditpoll']} readonly="readonly"{/if} />
            </p>
        <!--{/loop}-->
    <!--{/if}-->


    <div >
        <p>
            <input type="text" name="maxchoices" id="maxchoices" placeholder="{lang post_poll_allowmultiple} {if $_GET[action] == 'edit' && $poll[maxchoices]}$poll[maxchoices]{else}1{/if}"  /> {lang post_option}
        </p>
        <p>
            <input type="text" name="expiration" id="polldatas" placeholder="{lang post_poll_expiration}" /> {lang days}
        </p>
        <p>
            <input type="checkbox" name="visibilitypoll" id="visibilitypoll" value="1"{if $_GET[action] == 'edit' && !$poll[visible]} checked{/if}  />
            <label for="visibilitypoll">{lang poll_after_result}</label>
        </p>
        <p>
            <input type="checkbox" name="overt" id="overt" value="1"{if $_GET[action] == 'edit' && $poll[overt]} checked{/if}  />
            <label for="overt">{lang post_poll_overt}</label>
        </p>
    </div>
</div>