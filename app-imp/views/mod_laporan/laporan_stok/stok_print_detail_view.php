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
			 <span style="font-size:18pt;font-weight:bold;text-decoration:underline;">LAPORAN STOK HISTORY</span></td>

			</tr>
			<tr valign="top"> 
			 <td valign="middle" align="left" nowrap>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr> 
					 <td width="15%" align="left">Kode Produk</td>
					 <td width="2%">:</td>
					 <td width="10%" align="left"><?php echo $data_inventory->row()->produk_kode?></td>
					 <td nowrap>&nbsp;</td>
					 <td width="15%" nowrap align="left">Tgl. Cetak</td>
					 <td width="2%" nowrap>:</td>
					 <td width="10%" nowrap align="left"><?php echo date_format(date_create(date('Y-m-d H:i:s')),'d-M-Y H:i:s')?></td>
					</tr>
					<tr> 
					 <td align="left">Kategori</td>
					 <td nowrap>:</td>
					 <td nowrap align="left" valign="top" style="width:100px"><?php echo $data_inventory->row()->kat_nama?></td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					</tr>
					<tr>
					 <td align="left">Nama Produk</td>
					 <td nowrap>:</td>
					 <td nowrap align="left" valign="top" style="width:100px"><?php echo $data_inventory->row()->produk_nama?></td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					</tr>
					<tr>
					 <td align="left">Satuan</td>
					 <td nowrap>:</td>
					 <td nowrap align="left" valign="top" style="width:100px"><?php echo $data_inventory->row()->satuan_nama?></td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					 <td nowrap>&nbsp;</td>
					 <td nowrap align="left">&nbsp;</td>
					</tr>
				</table>
			 </td>
			 <td>&nbsp;</td>
			</tr>
			<tr>
			 <td colspan="3">&nbsp;</td>
			</tr>
			<tr> 
			 <td colspan="3" valign="top" nowrap>
				<table id="ItemPO" width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr align="center" valign="middle"  > 
						<td width="2%" align="center" nowrap><strong>No</strong></td>
						<td width="10%" align="center" nowrap><strong>Tgl</strong></td>
						<td width="10%" align="center" nowrap><strong>Mulai</strong></td>
						<td width="10%" align="center" nowrap><strong>Masuk</strong></td>
						<td width="10%" align="center" nowrap><strong>Keluar</strong></td>
						<td width="10%" align="center" nowrap><strong>Akhir</strong></td>
						<td width="15%" align="center" nowrap><strong>Hrg.Beli <br> (Rp)</strong></td>
						<td width="15%" align="center" nowrap><strong>Hrg.Jual <br> (Rp)</strong></td>
						<td width="10%" align="center" nowrap><strong>Dokumen</strong></td>
						<td width="10%" align="center" nowrap><strong>Operator</strong></td>
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
					if($data_inv_history->num_rows() > 0):
						$no=1;
						foreach($data_inv_history->result() as $rowb_det):
					?>
					<tr   valign="top"> 
						<td align="center" nowrap="nowrap"  ><?php echo $no?>.</td>
						<td nowrap="nowrap" align="center"><?php echo date_format(date_create($rowb_det->inv_tgl),'d-M-Y H:i:s')?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_mulai,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_masuk,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_keluar,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_akhir,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_hrg_beli,2)?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->inv_hrg_jual,2)?></td>
						<td align="center" nowrap="nowrap"><?php echo $rowb_det->inv_dokumen?></td>
						<td align="left" nowrap="nowrap"><?php echo $rowb_det->usr_nama?></td>
					</tr>
					<?php 
						$no++;
						endforeach;
					endif;
					?>
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