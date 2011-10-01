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
			 <span style="font-size:18pt;font-weight:bold;text-decoration:underline;">BON PEMBELIAN</span></td>

			</tr>
			<tr valign="top"> 
			 <td valign="middle" align="left" nowrap>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr> 
					 <td width="20%" align="left">No. Transaksi</td>
					 <td width="2%">:</td>
					 <td width="10%" align="left"><?php echo $data_beli->row()->beli_no?></td>
					 <td nowrap>&nbsp;</td>
					  <td width="15%" nowrap align="left">Tgl. Cetak</td>
					 <td width="2%" nowrap>:</td>
					 <td width="10%" nowrap align="left"><?php echo date_format(date_create(date('Y-m-d H:i:s')),'d-M-Y H:i:s')?></td>
					</tr>
					<tr> 
					 <td align="left">Tgl. Transaksi</td>
					 <td nowrap>:</td>
					 <td nowrap align="left" valign="top" style="width:100px"><?php echo date_format(date_create($data_beli->row()->beli_tgl),'d-M-Y H:i:s')?></td>
					 <td nowrap>&nbsp;</td>
					  <td nowrap align="left">Operator</td>
					 <td>:</td>
					 <td nowrap align="left"><?php echo $data_beli->row()->usr_nama?></td>
					 
					</tr>
					<tr>
					 <td colspan="2">&nbsp;</td>
					 <td nowrap align="left" valign="top" style="width:100px">&nbsp;</td>
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
						<td   width="2%" align="center" nowrap><strong>No</strong></td>
                        <td   width="20%" align="center" nowrap><strong>Pemasok</strong></td>
						<td   width="23%" align="center" nowrap><strong>Nama barang</strong><br/><strong>(Kode)</strong></td>
						<td   width="10%" align="center" nowrap><strong>Satuan</strong></td>
						<td   width="10%" align="center" nowrap><strong>Kuantitas</strong></td>
						<td   width="15%" align="center" nowrap><strong>Harga</strong></td>
						<td   width="15%" align="center" nowrap><strong>Total Harga</strong></td>
					</tr>
					<tr class="noscreen"  >
						<td colspan="7"  >
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td bgcolor="#999999">
										
									<td>
								</tr>
							</table>
						</td>
					</tr>
					<?php 
					if($data_beli_detail->num_rows() > 0):
						$no=1;
						foreach($data_beli_detail->result() as $rowb_det):
					?>
					<tr   valign="top"> 
						<td align="center" nowrap="nowrap"  ><?php echo $no?>.</td>
                        <td nowrap><?php echo $rowb_det->pemasok_nama?></td>
						<td nowrap="nowrap"  >
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td><?php echo $rowb_det->produk_nama?></td>
								</tr>
								<tr>
									<td>(<?php echo $rowb_det->produk_kode?>)</td>
								</tr>
							</table>
						</td>
						<td align="center" nowrap><?php echo $rowb_det->reqsat?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb_det->jumlah,2)?></td>
						<td align="right" nowrap="nowrap">Rp. <?php echo number_format($rowb_det->harga,2)?></td>
						<td align="right" nowrap="nowrap">Rp. <?php echo number_format($rowb_det->tot_harga,2)?></td>
					</tr>
					<?php 
						$no++;
						endforeach;
					endif;
					?>
					<tr class="noprint"  >
						<td colspan="7">
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
						<td valign="baseline">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td align="right" width="75%">
                                        <strong>Total Pembayaran :</strong>
                                    </td>
                                    <td align="right">
                                        <strong>Rp. <?php echo number_format($data_beli_detail->row()->udata_tot_harga,2)?></strong>
                                    </td>
                                    <td width="20">&nbsp;
                                    	
                                    </td>
								</tr>
							</table>
                        </td>
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