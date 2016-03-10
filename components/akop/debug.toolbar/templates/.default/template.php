<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<div class="debug-toolbar-container">
	<div class="debug-info">
		<div class="debug-list"></div>
		<div class="debug-detail"></div>
	</div>
	<div class="debug-toolbar debug-toolbar-max">
		<?foreach ($arResult["panels"] as $panel) :?>
			<div class="debug-toolbar-block">
				<span class="panel-name"><?=$panel["name"]?></span>
				<span class="panel-info <?=$panel["class"]?>"><?=$panel["info"]?></span>
			</div>
		<?endforeach;?>
		<span class="debug-toolbar-toggler">&gt;</span>
	</div>
	<div class="debug-toolbar debug-toolbar-mini hidden">
		<span class="debug-toolbar-toggler">&lt;</span>
	</div>
	<div class="helper debug-init">
	<?=json_encode($arResult["debug"], JSON_HEX_AMP | JSON_HEX_TAG);?>
	</div>
</div>