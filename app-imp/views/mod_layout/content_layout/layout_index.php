    <div id="art-page-background-gradient"></div>
    <div id="art-page-background-glare">
        <div id="art-page-background-glare-image"></div>
    </div>
    <div id="art-main">
        <div class="art-sheet">
			<?php 
			for ($i=0; $i <= 8; $i++):
			?>
            <div class="art-sheet-<?php echo $arrArt[$i]?> noprint"></div>
			<?php
			endfor;
			?>
            <div class="art-sheet-body">
                <?php $this->load->view('mod_layout/'.$layout_switch.'/layout_header')?>
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
						<!-- CONTENT -->
                        <div class="art-layout-cell art-content">
							<?php $this->load->view('mod_layout/'.$layout_switch.'/layout_content');?> 
                        </div>
                        <div class="art-layout-cell art-sidebar1">
							<?php $this->load->view('mod_layout/'.$layout_switch.'/layout_sidebar');?>
                        </div>
                    </div>
                </div>
                <div class="cleared"></div>
				<div class="art-footer">
                    <?php $this->load->view('mod_layout/'.$layout_switch.'/layout_footer');?>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
        <p class="art-page-footer">
			<i>
			<script type="text/javascript">
			//document.write(navigator.platform);
			</script>
			( rendered in {elapsed_time} seconds )
			<div id="debug-imp"></div>
			</i>
		</p>
    </div>