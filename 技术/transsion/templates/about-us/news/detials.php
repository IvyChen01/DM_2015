<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-17
 * Time: 上午11:21
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_news['title']; ?></title>
    <?php
	if (!empty($_news['keywords'])) echo '<meta name="keywords" content="' . $_news['keywords'] . '" />';
    if (!empty($_news['description'])) echo '<meta name="description" content="' . $_news['description'] . '" />';
	?>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en'><div id='wrapper'>";
    include("inc/head.php");
}
?>
    <div class="main">
        <div class="content clearfix">
        	<div class="position"><a href="<?php echo $_menu_info['main_link']; ?>"><?php echo $_menu_info['main_name']; ?></a> > <span class="cur-pos"><a href="<?php echo $_menu_info['sub_link']; ?>"><?php echo $_menu_info['sub_name']; ?></a></span></div>
            <div class="art-section">
                <div class="art-title"><?php echo $_news['title']; ?></div>
                <div class="art-date">
                <?php if (!empty($_news['news_from'])) { ?>
                    <span class="pub-week">From:<span class="value"><?php echo $_news['news_from']; ?></span></span>
                <?php } ?>
                    <span class="pub-date">Published on:<span class="value"><?php echo $_news['pubdate']; ?></span></span>
                </div>
                <div class="art-body">
                    <?php echo $_news['content']; ?>
                </div>
            </div>
            <div class="news-recommend">
                <div class="recom-til">Recommend</div>
                <div class="recom-list">
                </div>
            </div>
        </div>
    </div>
    <?php
	if ($_language_user == 'cn')
	{
		include("inc/cn_footer.php");
	}
	else
	{
		include("inc/footer.php");
	}
	?>
	<script type="text/javascript">
		$(document).ready(function(){
	    $.post("/?m=news&a=get_recommend_news_cn", {id: <?php echo $_news['id']; ?>}, function(data){
	        if (typeof data == "object" && Object.prototype.toString.call(data).toLowerCase() == "[object object]" && !data.length) {
	            if (data.code == 0) {
	                var doc = $(document.createDocumentFragment());
	                $.each(data.data,function(i,v){
	                    doc.append("<div class='recom-item'>" +
	                        "<a class='recom-link' href='"+ v.link+"' >" +
	                        "<img src='"+ v.image+"'>" +
	                        "<span class='rec-date'>"+ v.pubdate+"</span>" +
	                        "<div class='recom-desc'>"+ v.title+"</div>" +
	                        "</a>" +
	                        "</div>");
	                })
	                doc.appendTo(".recom-list");
	            }
	        }
	        },"json").error(function(){})
	});
	</script>
</div>
</body>
</html>