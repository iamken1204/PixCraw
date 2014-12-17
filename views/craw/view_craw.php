<?php
use yii\helpers\Url;
use app\assets\craw\CrawAsset;
CrawAsset::register($this);
?>

<input type="hidden" value="index.php/craw/getlink" id="url">
<div class="container-fluid">
	<div class="row">
		<div class="center">
			<div class="command">
				<div class="inText">
				  <div class="inline field">
				    <div class="ui pointing right	 label">
				      article =
				    </div>
						<div class="ui mini input focus">
						  <input type="text" id="artCode">
						</div>
				    <div class="ui pointing right	 label">
				      blog =
				    </div>
						<div class="ui mini input focus">
						  <input type="text" id="bloCode">
						</div>
						<div class="ui right labeled icon button btn" id="submit">
						  <i class="right arrow icon" id="submit"></i>
						  Go!
						</div>
				  </div>
				</div>
			</div>

			<div style="margin: 20px 0px 20px 0px;">
				<b>#只要有一個欄位打all, article跟blog都會全爬喔</b><br>
				總共抓取: <b id="count">0</b> 筆資料
			</div>

			<!-- <div class="ui active loader" id="loader"></div> -->
			<div class="spinner center" id="loader">
			  <div class="cube1"></div>
			  <div class="cube2"></div>
			</div>

			<div class="result">
			<b class="inText">網址：</b><br>
			</div>
		</div>
	</div>
</div>
