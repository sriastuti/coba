<table class="table table-hover table-bordered table-responsive">
				  <thead>
					<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Nama Supplier</p></th>
								  <th><p align="center">Rincian Obat</th>
								</tr>
							  </thead>
							  <tbody>
							 
						<?php
						
							$i=1;
							$vtot1=0;$vtot2=0;
							//print_r($data_laporan_keu);
							foreach($data_laporan_keu as $row){
							$supplier=$row->supplier_id;
							//$vtot1=$vtot1+$row->item_cost_price;
						?>
							<tr>

								<td align="center"><?php echo $i++;?></td>
								<td align="left"><?php echo strtoupper($row->company_name);?></td>
								<td>
									<table width='100%'>
									<thead>
										<tr>
											<th width='5%' >No</th>
											<th width='27%'>Nama Obat</th>
											<th width='17%'>Quantity</th>
											<th width='20%'>Nilai</th>
										</tr>
									</thead>
									<tbody>
								
								<?php $j=1; foreach($data_laporan_detail_keu as $row1){
									if($row1->supplier_id==$supplier){
									$vtot1=$vtot1+$row1->item_cost_price; ?>
								<tr><td align="center"><?php echo $j++;?></td>
								<td ><?php echo $row1->description;?></td>
								<td ><?php echo $row1->quantity_purchased;?></td>
								<!--<td><?php echo $row->biaya_obat;?></td>-->
								<td>Rp <div class="pull-right"><?php echo number_format( $row1->item_cost_price, 2 , ',' , '.' );?></div></td>		</tr>
						<?php }} ?>
							
					</tbody>
				</table>
			</td>

		</tr>							
						<?php
							}
						?>
							<tr>								
								<td colspan="2" align="right"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
								</tr>	
							  </tbody>
							 </table>
							 <br>					
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnExcel" name="btnExcel" class="btn btn-primary" href="<?php echo site_url('logistik_farmasi/Frmclaporan/export_excel/'.$tampil_per.'/'.$tgl);?>">Download Excel</a>
									<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('logistik_farmasi/Frmclaporan/lap_keu/'.$tampil_per.'/'.$tgl);?>">Cetak PDF</a>
								</div>
							</div>
