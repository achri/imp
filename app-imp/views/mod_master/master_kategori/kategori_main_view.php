<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo content_title($page_title,$path_themes);
	
?>

<script language="javascript">
	var katgrid_content = jQuery("#newapi<?php echo $kategori_grid['gridname'];?>"),
		kelasgrid_content = jQuery("#newapi<?php echo $kelas_grid['gridname'];?>"),
		grupgrid_content = jQuery("#newapi<?php echo $grup_grid['gridname'];?>"),
		kat_kode,lastsel,delret;
		
	function cek_hapus_kategori(tipe,id) {
		var stipe;
		switch (tipe){
			case 'kategori' : stipe = "<?php echo $class_use?>"; break;
			case 'kelas' : stipe = "<?php echo $group_use?>"; break;
			case 'grup' : stipe = "<?php echo $product_use?>"; break;
		}
		
		$.post('index.php/<?php echo $link_controller;?>/cek_hapus_kategori/'+tipe+'/'+id,function(data) {
			if (!data) {
				delret = [true];
			} else {
				delret = [false,stipe];;
			}
		});
		
		return delret;
	}
</script>

<div align="center">
<?php $this->load->view($link_view.'/kategori_kategori_grid_view')?>
<br>
<?php $this->load->view($link_view.'/kategori_kelas_grid_view')?>
<br>
<?php $this->load->view($link_view.'/kategori_grup_grid_view')?>
<br>
</div>