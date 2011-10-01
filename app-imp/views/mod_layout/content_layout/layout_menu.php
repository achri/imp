
<!-- VMENU BOX -->
<div class="art-vmenublock noprint">
	<?php 
	for ($i=0; $i <= 8; $i++):
	?>
	<div class="art-vmenublock-<?php echo $arrArt[$i]?>"></div>
	<?php
	endfor;
	?>
	<div class="art-vmenublock-body">
		<div class="art-vmenublockheader">
			<div class="l"></div>
			<div class="r"></div>
            <div class="t">Navigation</div>
        </div>
        <div class="art-vmenublockcontent">
			<div class="art-vmenublockcontent-body">
				<!-- block-content -->
				<ul class="art-vmenu">
					<li>
						<a href="#" class="active" module="home"><span class="l"></span><span class="r"></span><span class="t">Home</span></a>
                    </li>
					<?php 
						if (isset($list_menu))
							echo $list_menu;
					?>
					<li>
						<a href="#" module="logout"><span class="l"></span><span class="r"></span><span class="t">Logout</span></a>
                    </li>
				</ul>
				<!-- /block-content -->								
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>
	</div>
</div>