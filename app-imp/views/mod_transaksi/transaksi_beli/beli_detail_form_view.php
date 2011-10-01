<script type="text/javascript">
function switch_cabang(val) {
	jualdetgrid_content.jqGrid('setGridParam',{
		url:"<?php echo site_url($link_controller);?>/get_data/selling",
		postData:{"cb_id": val},
		page:1,
	});
	jualdetgrid_content.trigger('reloadGrid');
	beli_bersihkan();
	return false;
}

// AUTONUMERIC TOTAL HARGA @acc: grid
function change_tot_harga() {
	var strip = $.fn.autoNumeric.Strip('tot_harga'),
		grand_total = $.fn.autoNumeric.Format('tot_harga',strip);
	
	$('.tot_harga').val(grand_total).text(grand_total);
	return false;
}

// CALCULATION 
function kalkulasi(name,value) {
	var jumlah = parseFloat(($.fn.autoNumeric.Strip('jumlah')).replace(/,/g,'')),
		jumlah_multi = parseFloat(($.fn.autoNumeric.Strip('jumlah_multi')).replace(/,/g,'')),
		diskon = parseFloat(($.fn.autoNumeric.Strip('diskon')).replace(/,/g,'')),
		harga = parseFloat(($.fn.autoNumeric.Strip('harga')).replace(/,/g,'')),
		last_buying = parseFloat(($.fn.autoNumeric.Strip('last_buying')).replace(/,/g,'')),
		satuan_volume = $('#satuan_id option:selected').attr('volume'),
		total_harga, total_diskon;
		
	if(isNaN(jumlah))
		jumlah = 0;
		
	if(isNaN(diskon))
		diskon = 0;
			
	if(isNaN(harga))
		harga = 0;
		
	if (satuan_volume <= 1)
		jumlah_multi = 1;

	set_multi = jumlah * jumlah_multi;
	total_harga =  set_multi * harga;
	total_diskon = total_harga * (diskon / 100);
	total_harga -= total_diskon;
	
	$('#tot_diskon').val(total_diskon);
	$('#tot_harga').val(total_harga);
		
	change_tot_harga();
	masking_reload('.number');
	return false;
}

$(document).ready(function() {	
	/* BIG AUTOCOMPLETE FUTURED HELPER COMMING^^ */
	try {
		var $beli_form = $('form#beli_form'),
			$KEY = new Array(9,13,16,17,18,20,33,34,35,36,37,38,39,40), // 8 backspace,46 del
			$SET = {'produk_kode': true, 'produk_nama': true, 'pemasok_nama':true }; // FIRST CONDITION FOR AUTOCOMPLETE SELECTOR
		
		// METHOD KEYUP FOR CLASS AUTOCOMPLETE
		$('input.auto',$beli_form).keyup(function(event){	
			var $item = $(this),
				$item_id = $item.attr('id'),
				$type = $item.attr('name'),
				$check_key = $.inArray(event.keyCode,$KEY); // FIND IDX OF $KEY ARRAY IN THIS METHOD
								
			// CLEAR VALUE OF CL CLASS IF NOT THIS SELECTOR
			try {
				if ($check_key == -1) {
					$('input.cl:not(#'+$item_id+')',$beli_form).val('');
					$('select#satuan_id option:not(:first)').remove();
				}
			} catch(e) { alert("AJAX ERROR : " + e);};
			
			if ($SET[$type]){	
				// BIND ONE TIME AUTOCOMPLETE FOR THIS SELECTOR
				$item.unautocomplete().autocomplete('<?php echo site_url($link_controller)?>/list_autocomplate',
				{
					inputClass: "ac_input",
					resultsClass: "ac_results",
					loadingClass: "ac_loading",
					minChars: 2,
					delay: 400,
					matchCase: true,
					matchSubset: true,
					matchContains: false,
					cacheLength: 10,
					max: 10,
					mustMatch: false,
					extraParams: {
						'tipe': $type
					},
					selectFirst: true,
					formatItem: function(item,idx,max,result,keyup) { 
						//return false;
						return item[0]; 
					},
					formatMatch: function(result,idx,length) {
						//alert(result+'>'+idx+'>'+length);
						return result;
					},
					autoFill: false,
					width: 'auto',
					multiple: false,
					multipleSeparator: ", ",
					highlight: function(value, term) {
						return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<b style='color:red'>$1</b>");
					},
					scroll: true,
					scrollHeight: 180
				})
				.result(function(event,item) {
					// CASE OF RESULT ARRAY
					switch ($type) {
						case 'produk_kode' : $('#produk_nama').val(item[2]); break;
						case 'produk_nama' : $('#produk_kode').val(item[3]); break;
					}
					
					// DEFAULT SET DATA
					$('#produk_id').val(item[1]);
					$('#cb_id').val(item[8]);
					$('#kat_id').val(item[4]);
					$('#kat_nama').val(item[5]);
					$('#last_buying').val(item[7]);
					$('#harga').val(item[7]);
					$('#tot_harga').val(item[7]);
					$('#jumlah').val('1').focus();
					$('#jumlah_multi').val('1');
					$('#diskon').val('0');
					$('#tot_diskon').val('0');
					
					// POPULATE MULTI UNIT
					var produk_id = item[1],
						satuan_id = item[6];
					
					$('#satuan_id').load('<?php echo site_url($link_controller)?>/set_multi_satuan/'+produk_id+'/'+satuan_id);
					
					change_tot_harga();
					masking_reload('.number');
					return false;
				});
				$SET[$type] = false;
			}
			
			return false;
		});
	} catch(e) { alert("AJAX ERROR : " + e);};
	
	$('#pemasok_nama').autocomplete('<?php echo site_url($link_controller)?>/list_autocomplate',{
		extraParams: {
			'tipe': 'pemasok_nama'
		}
	}).result(function(event,item) {
		$('#pemasok_id').val(item[1]);
	});;
	
	/* CALCULATION PRICE */			
	$('.kalkulasi').blur(function(event){
		var item = $(this),
			item_id = item.attr('id');
			name = item.attr('name'),
			value= parseFloat(($.fn.autoNumeric.Strip(item_id)).replace(/,/g,''));
			
		kalkulasi();
		return false;
	});
	
	/* CALCULATION MULTI SATUAN */
	$('#satuan_id').change(function() {
		var item = $(this),
			name = item.attr('name'),
			value = $(':selected',item).attr('volume');
			
		$('#jumlah_multi').val(value);
		kalkulasi();
	});
});
/* first default action */
$('input:not(#kat_nama,#pemasok_nama)').attr('size',15);
$('.number').attr('digit_decimal',2);
</script>
<form id="beli_form"> 
<fieldset class="ui-widget-content ui-corner-all"> 
	<legend class="ui-corner-all ui-state-active">BUYING FORM</legend>
	<legend class="ui-corner-all ui-state-active"  style="float:right;margin-top:-23px;">
		Cabang: 
		<select id="cb_id" onchange="switch_cabang(this.value);">
			<?php echo $opt_cabang;?>
		</select>
	</legend>
	<table width="100%" class="ui-widget-content" border=0 style="border:0px"> 
		<tbody valign="top"> 
			<tr> 
				<td width="100px">Product Code</td> 
				<td width="5px">:</td>
				<td width="40%">
					<input class="beli_form" type="hidden" name="cb_id" id="cb_id" title=""/>	
					<input class="beli_form" type="hidden" name="beli_id" id="beli_id" title=""/>	
					<input class="beli_form required cl" type="hidden" name="produk_id" id="produk_id" title="Product"/>	
					<input class="beli_form auto cl" type="text" name="produk_kode" id="produk_kode"/>	
				</td>
				<td width="20px">&nbsp;</td>
				<td width="100px">Unit</td> 
				<td width="5px">:</td>
				<td>
					<select class="beli_form required select auto cl" name="satuan_id" id="satuan_id" title="Unit"/>
					</select>
				</td>
			</tr> 
			<tr> 
				<td>Product Name</td> 
				<td>:</td>
				<td>
					<input class="beli_form auto cl" type="text" name="produk_nama" id="produk_nama"/> 
					&nbsp; <input type="hidden" class="btn-list ui-widget-header" style="cursor:pointer" value="list product"/>
				</td>
				<td>&nbsp;</td>
				<td>Qty</td> 
				<td>:</td>
				<td>
					<input class="beli_form required number kalkulasi" type="text" name="jumlah" id="jumlah" title="Qty"/>
					<input class="beli_form" type="" name="jumlah_multi" id="jumlah_multi" title="Qty Multi Level"/>
				</td>
			</tr> 
			<tr> 
				<td>Category</td> 
				<td>:</td>
				<td>
					<input class="beli_form cl" type="hidden" name="kat_id" id="kat_id"/>
					<input readonly class="beli_form cl" type="text" name="kat_nama" id="kat_nama" size="50"/>
				</td>
				<td>&nbsp;</td>
				<td>Last Buying (Rp)</td>
				<td>:</td>
				<td>
					<input readonly class="beli_form number cl" type="text" name="last_buying" id="last_buying"/>
				</td>
			</tr> 
			<tr>
				<td>Supplier</td>
				<td>:</td>
				<td>
					<input class="beli_form required" type="hidden" name="pemasok_id" id="pemasok_id" title="Supplier"/> 
					<input class="beli_form" type="text" name="pemasok_nama" id="pemasok_nama" title="Supplier" size="30"/>
					&nbsp; <input type="hidden" class="btn-list ui-widget-header" style="cursor:pointer" value="list supplier"/>
					<input class="beli_form number kalkulasi" type="hidden" name="diskon" id="diskon" title="Discount"/> 
					<input readonly class="beli_form number kalkulasi" type="hidden" name="tot_diskon" id="tot_diskon" title="Total Discount"/>
				</td>
				<td>&nbsp;</td>
				<td>Buying (Rp)</td>
				<td>:</td>
				<td>
					<input class="beli_form required number kalkulasi" type="text" name="harga" id="harga" title="Price"/>
				</td>
			</tr>
			<tr><td colspan=7><hr></td></tr>
			<tr> 
				<td>
					<input onclick="beli_add(this.value);" type="button" id="beli_tambah" value="ADD" />
				</td>
				<td></td>
				<td>
					<input onclick="beli_edit(this.value);" type="button" id="beli_ubah" value="EDIT" />
					<input onclick="beli_delete(this.value);" type="button" id="beli_hapus" value="DELETE" />
					
					<input onclick="beli_kondisi_awal();" type="button" id="beli_batal" value="CANCEL" />
					<input type="reset" value="CLEAR" />
				</td>
				<td>&nbsp;</td>				
				<td style="font:18px arial black" align="right">Total (Rp)</td>
				<td style="font:18px arial black">:</td>
				<td style="font:18px arial black" class="tot_harga" id="kalkulasi">0.00</td>
			</tr> 
		</tbody> 
	</table> 
</fieldset> 
<input class="number tot_harga" type="hidden" id="tot_harga" digit_decimal=2 name="tot_harga">
</form>