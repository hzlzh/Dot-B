<?php
/*
Template Name: Template-Search
*/
?>
<?php get_header(); ?>
<!-- CSS style begin -->

<style type="text/css">
#control{
			color: #BD0800;
		    cursor: row-resize;
		    padding-left: 10px;
		    text-shadow: 0 0 1px #FFFFFF;
		
		}
.my-archive{
	margin: 10px;
}
.my-archive h3 span{
    color: #555;
    cursor: move;
    margin-top: 3px;
    padding: 3px 5px;
}
.my-archive ul.day li{
    list-style: circle inside none;
    padding-left: 15px;
    padding-top: 2px;

}
.my-archive ul.month li{
list-style: square inside none;
cursor: s-resize;

}
.comments_number{
	color:#999;
}
</style>


<div id="main">
	<div id="content">
			
			<div id="cse" style="width: 100%;">   Loading... </div>
			<script src="//www.google.com/jsapi" type="text/javascript"></script>
			<script type="text/javascript"> 
			  function parseQueryFromUrl () {
			    var queryParamName = "q";
			    var search = window.location.search.substr(1);
			    var parts = search.split('&');
			    for (var i = 0; i < parts.length; i++) {
			      var keyvaluepair = parts[i].split('=');
			      if (decodeURIComponent(keyvaluepair[0]) == queryParamName) {
			        return decodeURIComponent(keyvaluepair[1].replace(/\+/g, ' '));
			      }
			    }
			    return '';
			  }

			  google.load('search', '1', {style : google.loader.themes.GREENSKY});
			  google.setOnLoadCallback(function() {
			    var customSearchControl = new google.search.CustomSearchControl('011726169853656484522:gvikl69lrew');
			    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
			    var options = new google.search.DrawOptions();
			    options.setAutoComplete(true);
			    options.enableSearchResultsOnly(); 
			    customSearchControl.draw('cse', options);
			    var queryFromUrl = parseQueryFromUrl();
			    if (queryFromUrl) {
			      customSearchControl.execute(queryFromUrl);
			    }
			  }, true);
			</script>

			<style type="text/css">
			  .gsc-control-cse {
			    font-family: Verdana, sans-serif;
			    border-color: #f1f1f1;
			    background-color: #f1f1f1;
			  }
			  .gsc-tabHeader.gsc-tabhInactive {
			    border-color: #f1f1f1;
			    background-color: #FFFFFF;
			  }
			  .gsc-tabHeader.gsc-tabhActive {
			    border-color: #AAAAAA;
			    background-color: #F1F1F1;
			  }
			  .gsc-tabsArea {
			    border-color: #AAAAAA;
			  }
			  .gsc-webResult.gsc-result,
			  .gsc-results .gsc-imageResult {
			    border-color: #33cc00;
			    background-color: #f1f1f1;
			  }
			  .gsc-webResult.gsc-result:hover,
			  .gsc-imageResult:hover {
			    border-color: #99ff99;
			    background-color: #99ff99;
			  }
			  .gs-webResult.gs-result a.gs-title:link,
			  .gs-webResult.gs-result a.gs-title:link b,
			  .gs-imageResult a.gs-title:link,
			  .gs-imageResult a.gs-title:link b {
			    color: #0066CC;
			  }
			  .gs-webResult.gs-result a.gs-title:visited,
			  .gs-webResult.gs-result a.gs-title:visited b,
			  .gs-imageResult a.gs-title:visited,
			  .gs-imageResult a.gs-title:visited b {
			    color: #cc33cc;
			  }
			  .gs-webResult.gs-result a.gs-title:hover,
			  .gs-webResult.gs-result a.gs-title:hover b,
			  .gs-imageResult a.gs-title:hover,
			  .gs-imageResult a.gs-title:hover b {
			    color: #bd0800;
			  }
			  .gs-webResult.gs-result a.gs-title:active,
			  .gs-webResult.gs-result a.gs-title:active b,
			  .gs-imageResult a.gs-title:active,
			  .gs-imageResult a.gs-title:active b {
			    color: #0066CC;
			  }
			  .gsc-cursor-page {
			    color: #0066CC;
			  }
			  a.gsc-trailing-more-results:link {
			    color: #0066CC;
			  }
			  .gs-webResult .gs-snippet,
			  .gs-imageResult .gs-snippet {
			    color: #333333;
			  }
			  .gs-webResult div.gs-visibleUrl,
			  .gs-imageResult div.gs-visibleUrl {
			    color: #009900;
			  }
			  .gs-webResult div.gs-visibleUrl-short {
			    color: #009900;
			  }
			  .gs-webResult div.gs-visibleUrl-short {
			    display: none;
			  }
			  .gs-webResult div.gs-visibleUrl-long {
			    display: block;
			  }
			  .gsc-cursor-box {
			    border-color: #33cc00;
			  }
			  .gsc-results .gsc-cursor-box .gsc-cursor-page {
			    border-color: #f1f1f1;
			    background-color: #f1f1f1;
			    color: #0066CC;
			  }
			  .gsc-results .gsc-cursor-box .gsc-cursor-current-page {
			    border-color: #AAAAAA;
			    background-color: #F1F1F1;
			    color: #cc33cc;
			  }
			  .gs-promotion {
			    border-color: #94CC7A;
			    background-color: #CBE8B4;
			  }
			  .gs-promotion a.gs-title:link,
			  .gs-promotion a.gs-title:link *,
			  .gs-promotion .gs-snippet a:link {
			    color: #0066CC;
			  }
			  .gs-promotion a.gs-title:visited,
			  .gs-promotion a.gs-title:visited *,
			  .gs-promotion .gs-snippet a:visited {
			    color: #0066CC;
			  }
			  .gs-promotion a.gs-title:hover,
			  .gs-promotion a.gs-title:hover *,
			  .gs-promotion .gs-snippet a:hover {
			    color: #0066CC;
			  }
			  .gs-promotion a.gs-title:active,
			  .gs-promotion a.gs-title:active *,
			  .gs-promotion .gs-snippet a:active {
			    color: #0066CC;
			  }
			  .gs-promotion .gs-snippet,
			  .gs-promotion .gs-title .gs-promotion-title-right,
			  .gs-promotion .gs-title .gs-promotion-title-right *  {
			    color: #666666;
			  }
			  .gs-promotion .gs-visibleUrl,
			  .gs-promotion .gs-visibleUrl-short {
			    color: #815FA7;
			  }
							.cse .gsc-results, .gsc-results {background:#f1f1f1!important;}
							b{color:#cc0000;}
			</style>
	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<?php get_footer(); ?>