<?php
	// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
	ob_end_clean();
		$filename = "Kerja sama.xls";
		header("Content-type: application/vnd-ms-excel");
		header('Content-Disposition: attachment;filename="'. $filename);
	ob_end_clean();

?>

<table border="1">
	<thead style="background-color: grey;">
		<tr>
			<th rowspan="2" style="text-align: center;">No</th>
			<th rowspan="2" style="text-align: center;">Mitra</th>
			<th colspan="2" style="text-align: center;">Nomor MOU</th>
			<th colspan="3" style="text-align: center;">Tanggal MOU</th>
			<th rowspan="2" style="text-align: center;">Bidang Kerjasama</th>
			<th rowspan="2" style="text-align: center;">Tindak Lanjut MoU</th>
			<th colspan="3" style="text-align: center;">Tanggal PKS (MoA)</th>
			<th colspan="2" style="text-align: center;">Nomor PKS (MoA)</th>
			<th rowspan="2" style="text-align: center;">Bidang Kerjasama</th>
			<th rowspan="2" style="text-align: center;">Sub Bidang Kerjasama</th>
			<th rowspan="2" style="text-align: center;">Biaya</th>
			<th colspan="2" style="text-align: center;">Contact Person</th>
			<th colspan="2" style="text-align: center;">Alamat Mitra</th>
			<th rowspan="2" style="text-align: center;">Tindak Lanjut PKS</th>
		</tr>
		<tr>
			<th style="text-align: center;">No.MoU FILKOM</th>
			<th style="text-align: center;">No.MoU Mitra Kerjasama</th>
			<th style="text-align: center;">Tgl MoU Mulai</th>
			<th style="text-align: center;">Tgl MoU Berakhir</th>
			<th style="text-align: center;">Jangka Waktu MoU</th>
			<th style="text-align: center;">Tgl PKS Mulai</th>
			<th style="text-align: center;">Tgl PKS Berakhir</th>
			<th style="text-align: center;">Jangka Waktu PKS</th>
			<th style="text-align: center;">No.PKS  Unit FILKOM</th>
			<th style="text-align: center;">No.PKS Mitra Kerjasama</th>
			<th style="text-align: center;">FILKOM UB</th>
			<th style="text-align: center;">Mitra Kerjasama</th>
			<th style="text-align: center;">MoU</th>
			<th style="text-align: center;">PKS</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1;
			foreach ($kerjasama as $valkerjasama) {
				$mou = $this->mymodel->selectdataone('kerja_sama',['ks_tipe'=>'mou','ks_mitra_id'=>$valkerjasama['ks_mitra_id']]);
				$moa = $this->mymodel->selectWhere('kerja_sama',['ks_tipe'=>'moa','ks_mitra_id'=>$valkerjasama['ks_mitra_id']]);
		?>
			<tr>
				<td rowspan="<?= count($moa)?>" ><?= $no; ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $valkerjasama['ks_mitra_name'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_no_mou_filkom'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_no_mou_mitra'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_tgl_mulai'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_tgl_selesai'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_jangka_waktu'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_bidang'] ?></td>
				<td rowspan="<?= count($moa)?>" ><?= $mou['ks_tindak_lanjut'] ?></td>
				<td><?= $moa[0]['ks_tgl_mulai']?></td>
				<td><?= $moa[0]['ks_tgl_selesai']?></td>
				<td><?= $moa[0]['ks_jangka_waktu']?></td>
				<td><?= $moa[0]['ks_no_moa_filkom']?></td>
				<td><?= $moa[0]['ks_no_moa_mitra']?></td>
				<td><?= $moa[0]['ks_bidang']?></td>
				<td><?= $moa[0]['ks_subidang']?></td>
				<td></td>
				<td><?= $moa[0]['ks_cp_filkom']?></td>
				<td><?= $moa[0]['ks_cp_mitra']?></td>
				<td><?= $mou['ks_alamat_mitra']?></td>
				<td><?= $moa[0]['ks_alamat_mitra']?></td>
				<td><?= $moa[0]['ks_tindak_lanjut']?></td>
			</tr>
			<?php for ($i=1; $i < count($moa) ; $i++) {?>
				<tr>
					<td><?= $moa[$i]['ks_tgl_mulai']?></td>
					<td><?= $moa[$i]['ks_tgl_selesai']?></td>
					<td><?= $moa[$i]['ks_jangka_waktu']?></td>
					<td><?= $moa[$i]['ks_no_moa_filkom']?></td>
					<td><?= $moa[$i]['ks_no_moa_mitra']?></td>
					<td><?= $moa[$i]['ks_bidang']?></td>
					<td><?= $moa[$i]['ks_subidang']?></td>
					<td></td>
					<td><?= $moa[$i]['ks_cp_filkom']?></td>
					<td><?= $moa[$i]['ks_cp_mitra']?></td>
					<td><?= $mou['ks_alamat_mitra']?></td>
					<td><?= $moa[$i]['ks_alamat_mitra']?></td>
					<td><?= $moa[$i]['ks_tindak_lanjut']?></td>
				</tr>
			<?php }?>
		<?php $no++; }?>
	</tbody>
</table>