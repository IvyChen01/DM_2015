<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-6-12
 * Time: 上午11:27
 */
?>
<div class="top">
    <div class="main">
        <div class="home <?php if($pageId==1) echo 'cur-page' ?>"><a href="/">主页</a></div>
        <div class="answer-page <?php if($pageId==2) echo 'cur-page' ?>"><a href="?m=faq&a=show_question">不看不知道</a></div>
        <div class="winners-list <?php if($pageId==3) echo 'cur-page' ?>"><a href="?m=faq&a=show_lucky">中奖名单</a></div>
        <div class="user-box">
            <p class="user-name"><?php echo $_username; ?></p>
            <a href="?m=user&a=show_change_password" class="change-pwd <?php if($pageId==4) echo 'cur-page' ?>">修改密码</a>/<a href="?m=user&a=logout" class="login-out">退出</a>
        </div>
    </div>
</div>