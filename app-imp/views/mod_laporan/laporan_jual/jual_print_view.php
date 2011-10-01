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
			 <span style="font-size:18pt;font-weight:bold;text-decoration:underline;">TRANSAKSI PENJUALAN</span></td>

			</tr>
			<tr valign="top"> 
			 <td valign="middle" align="left" nowrap>&nbsp;</td>
			 <td>&nbsp;</td>
			</tr>
			
			<tr> 
			 <td colspan="3" valign="top" nowrap>
				<table id="ItemPO" width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr align="center" valign="middle"  > 
						<td   width="2%" align="center" nowrap><strong>No</strong></td>
						<td   width="23%" align="center" nowrap><strong>Tgl. Pembelian</strong><strong></strong></td>
						<td   width="10%" align="center" nowrap><strong>No. Pembelian</strong></td>
						<td   width="10%" align="center" nowrap><strong>Tot. Jumlah</strong></td>
						<td   width="15%" align="center" nowrap><strong>Tot. Harga</strong></td>
                        <td   width="15%" align="center" nowrap><strong>Bayar</strong></td>
                        <td   width="15%" align="center" nowrap><strong>Pembayaran</strong></td>
                        <td   width="15%" align="center" nowrap><strong>Operator</strong></td>
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
					if($data_jual->num_rows() > 0):
						$no=1;
						foreach($data_jual->result() as $rowb):
					?>
					<tr   valign="top"> 
						<td align="center" nowrap="nowrap"  ><?php echo $no?>.</td>
						<td nowrap="nowrap" align="center"><?php echo date_format(date_create($rowb->jual_tgl),'d-M-Y H:i:s')?></td>
						<td align="center" nowrap><?php echo $rowb->jual_no?></td>
						<td align="right" nowrap="nowrap"><?php echo number_format($rowb->jual_tot_jml,2)?></td>
						<td align="right" nowrap="nowrap">Rp. <?php echo number_format($rowb->jual_tot_hrg,2)?></td>
                        <td align="right" nowrap="nowrap">Rp. <?php echo number_format($rowb->jual_tot_bayar,2)?></td>
                        <td align="center" nowrap="nowrap"><?php echo $rowb->jenis_transaksi?></td>
                        <td align="left" nowrap="nowrap"><?php echo $rowb->usr_nama?></td>
					</tr>
					<?php 
						$no++;
						endforeach;
					endif;
					?>
					<tr class="noprint"  >
						<td colspan="13">
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