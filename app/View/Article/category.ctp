<?
	$id = $this->request->params['pass'][0];
?>

<div class="row">
    <div class="page-title"><?=$aCategoryOptions[$id]?></div>
</div>

<div class="row profile-articles">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
<?
	if ($aArticles) {
		foreach($aArticles as $article) {
?>
		<div class="col-md-4 col-sm-6 col-xs-12 mb10">
			<div class="news-article ">
				<!--div class="dimention-link">
                    <a href="javascript:void(0)"><?=$aCategoryOptions[$id]?></a>
                </div-->
				<a href=<?=$this->Html->url(array("action" => "view", $article['Article']['id']));?>>
					<div class="news-article-title"><?=$article['Article']['title']?></div>
				</a>
				<div class="news-article-pubdate">
					<!--div class="comments-num">
						<span class="glyphicons comments"></span> 8
					</div-->
				</div>
			</div>        
		</div>
<?
		}
	} else { 
		echo __('No articles int this category yet');
	}
?>
    </div>
    </div>
</div>