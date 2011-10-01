<link type="text/css" rel="stylesheet" media="print" href="<?php echo base_url()?>asset/css/print/print_template.css" />
<script language="javascript">
print();
top.close();
</script>
<table width="756" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
	<tr bgcolor="#FFFFFF">
		<td>
		 <table width="100%" border="0 cellpadding="0" cellspacing="0">
			<tr>
			 <td colspan="2" valign="top" nowrap>
			 <span style="font-size:18pt;font-weight:bold;text-decoration:underline;">LAPORAN STOK PRODUK</span></td>

			</tr>
			<tr valign="top"> 
			 <td valign="middle" align="left" nowrap>&nbsp;</td>
			 <td>&nbsp;</td>
			</tr>
			
			<tr> 
			 <td colspan="3" valign="top" nowrap>
				<table id="ItemPO" width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr align="center" valign="middle"  > 
						<td width="2%" align="center" nowrap><strong>No</strong></td>
						<td width="10%" align="center" nowrap><strong>Tgl</strong></td>
						<td width="10%" align="center" nowrap><strong>Kode</strong></td>
						<td width="15%" align="center" nowrap><strong>Kategori</strong></td>
						<td width="15%" align="center" nowrap><strong>Satuan</strong></td>
						<td width="15%" align="center" nowrap><strong>Min Stok</strong></td>
						<td width="15%" align="center" nowrap><strong>Stok</strong></td>
						<td width="15%" align="center" nowrap><strong>Harga Beli <br> (Rp)</strong></td>
						<td width="15%" align="center" nowrap><strong>Harga Jual <br> (Rp)</strong></td>
					</tr>
					<tr class="noscreen"  >
						<td colspan="20"  >
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td bgcolor="#999999">
										
									<td>
								</tr>
							</table>
						</td>
					</tr>
					<?php 
					if($data_inventory->num_rows() > 0):
						$no=1;
						foreach($data_inventory->result() as $rowb):
					?>
					<tr   valign="top"> 
						<td align="center" nowrap="nowrap"  ><?php echo $no?>.</td>
						<td nowrap="nowrap" align="center"><?php echo date_format(date_create($rowb->inv_tgl),'d-M-Y H:i:s')?></td>
						<td align="center" nowrap><?php echo $rowb->produk_kode?></td>
						<td align="left" nowrap><?php echo $rowb->kat_nama?></td>
						<td align="center" nowrap><?php echo $rowb->satuan_nama?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb->produk_min_stok,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb->inv_akhir,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb->inv_hrg_beli,2)?></td>
                        <td align="right" nowrap="nowrap"><?php echo number_format($rowb->inv_hrg_jual,2)?></td>
					</tr>
					<?php 
						$no++;
						endforeach;
					endif;
					?>
					<tr valign="top"> 
						<td align="right" nowrap="nowrap" colspan=7><strong>TOTAL :</strong>&nbsp;</td>
						<td align="right" nowrap="nowrap"><strong><?php echo number_format($rowb->udata_inv_hrg_beli,2)?></strong></td>
                        <td align="right" nowrap="nowrap"><strong><?php echo number_format($rowb->udata_inv_hrg_jual,2)?></strong></td>
					</tr>
					<tr class="noprint"  >
						<td colspan="20">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td>
										
										</td>
								</tr>
							</table>
						</td>
					</tr>
			   </table>
			</td>
		</tr>
		<tr> 
			<td colspan="3" nowrap> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr> 
						<td valign="baseline">&nbsp;</td>
					</tr>
					<tr>
						<td>
						<?php 
						//echo $notes;
						?>
						</td>
					</tr>
					<tr> 
						<td valign="baseline">&nbsp;</td>
					</tr>
					<tr> 
						<td valign="baseline">
							<table width="40%" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td align="center">Dicetak oleh</td>
								</tr>
								<tr> 
									<td align="center">&nbsp;</td>
								</tr>
								<tr> 
									<td align="center">&nbsp;</td>
								</tr>
								<tr> 
									<td align="center"><br/>&nbsp;</td>
								</tr>
								<tr> 
									<td align="center">(<u>&nbsp;<?php echo $this->session->userdata('usr_nama')?>&nbsp;</u>)</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	  </table>
	 </td>
	</tr>
</table>
</td></tr></table>
</div>