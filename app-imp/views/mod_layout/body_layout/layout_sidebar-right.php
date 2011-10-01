<script language="javascript">
function debuging(sel) {
	var bg = $(sel).html();
	if (bg && bg != '.') {
		$('#so-debug').text(bg);
	} else {
		$('#so-debug').text('');
	}
		
	return false;
}
</script>
<!-- ART BOX -->
<div class="art-block noprint">
	<?php 
	for ($i=0; $i <= 8; $i++):
	?>
    <div class="art-block-<?php echo $arrArt[$i]?>"></div>
	<?php
	endfor;
	?>
    <div class="art-block-body">
		<div class="art-blockheader">
			<div class="l"></div>
			<div class="r"></div>
			<div class="t">Information</div>
		</div>
		<div class="art-blockcontent">
			<?php 
			for ($i=0; $i <= 8; $i++):
			?>
            <div class="art-blockcontent-<?php echo $arrArt[$i]?>"></div>
			<?php
			endfor;
			?>
			<div class="art-blockcontent-body">
				<!-- block-content -->
				<?php $this->load->view('mod_info/info_stok/stok_main_view')?>
				<!-- /block-content -->
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>
	</div>
</div>

<!-- ART BOX -->
<?php if ($this->config->item('debug')):?>
<div class="art-block noprint">
	<?php 
	for ($i=0; $i <= 8; $i++):
	?>
    <div class="art-block-<?php echo $arrArt[$i]?>"></div>
	<?php
	endfor;
	?>
    <div class="art-block-body">
		<div class="art-blockheader">
			<div class="l"></div>
			<div class="r"></div>
			<div class="t">DEBUGING</div>
		</div>
		<div class="art-blockcontent">
			<?php 
			for ($i=0; $i <= 8; $i++):
			?>
            <div class="art-blockcontent-<?php echo $arrArt[$i]?>"></div>
			<?php
			endfor;
			?>
			<div class="art-blockcontent-body">
				<!-- block-content -->
				<div>Debug <input onkeyup="debuging(this.value)"/></div>
				<div id="so-debug"></div>
				<!-- /block-content -->
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>
	</div>
</div>
<?php endif;?>
