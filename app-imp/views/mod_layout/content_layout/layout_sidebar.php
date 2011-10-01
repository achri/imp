<?php $this->load->view('mod_layout/'.$layout_switch.'/layout_menu')?>

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
				
				<!-- /block-content -->
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>
	</div>
</div>