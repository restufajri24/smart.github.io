<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){
	?>
	<script>window.location.assign("login.php")</script>
	<?php
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>SPK Metode SMART</title>
    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<h2 style="text-align:center;">LAPORAN PERANGKINGAN SISTEM PENDUKUNG KEPUTUSAN METODE SMART</h2>
	<p><strong>Nilai Dasar</strong></p>
	<table class="table striped hovered cell-hovered border bordered">
	<thead>
		<tr>
			<th width="50">ID</th>
            <th>Nama Mahasiswa</th>
            <th>Divisi</th>
			 <?php
            $stmt2 = $db->prepare("select * from smart_kriteria");
            $stmt2->execute();
            while($row2 = $stmt2->fetch()){
            ?>
			<th><?php echo $row2['nama_kriteria'] ?></th>
            <?php
            }
            ?>		</tr>
	</thead>
	<tbody>
		<?php
		$stmt = $db->prepare("select * from smart_alternatif_kriteria");
		$stmt->execute();
        $no = 1;
		while($row = $stmt->fetch()){
		?>
		<tr>
			<td><?php echo $no++ ?></td>
            <td>
				<?php
				$stmt2 = $db->prepare("select * from smart_siswa where id_siswa='".$row['id_siswa']."'");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_siswa'] ?>
				<?php
				}
				?>
			</td>
            <td>
				<?php
				$stmt2 = $db->prepare("select * from smart_mapel where id_mapel='".$row['id_matapelajaran']."'");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_mapel'] ?>
				<?php
				}
				?>
			</td>
			<td><?php echo $row['keaktifan'] ?></td>
			<td><?php echo $row['tugas'] ?> </td>
            <td><?php echo $row['kuis'] ?></td>
            <td><?php echo $row['uts'] ?></td>
            <td><?php echo $row['uas'] ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
	</table>
	<br/>
	<p><strong>Nilai Perangkingan</strong></p>
	<table class="table striped hovered cell-hovered border bordered">
	<thead>
		<tr>
			<th width="50">No</th>
			<th>Nama Mahasiswa</th>
            <th>Divisi</th>
			 <?php
            $stmt2 = $db->prepare("select * from smart_kriteria");
            $stmt2->execute();
            while($row2 = $stmt2->fetch()){
            ?>
			<th><?php echo $row2['nama_kriteria'] ?></th>
            <?php
            }
            ?>
			<th>Hasil</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>-</td>
			<td>Bobot</td>
            <td>-</td>
			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria");
            $stmt2x1->execute();
            while($row2x1 = $stmt2x1->fetch()){
            ?>
			<td><?php echo $row2x1['bobot_kriteria'] ?></td>
			<?php } ?>
            <td>-</td>
            <td>-</td>
		</tr>
		<?php
		$stmt = $db->prepare("select * from smart_nilai");
		$stmt->execute();
        $no = 1;
		while($row = $stmt->fetch()){
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td>
                <?php
				$stmt2 = $db->prepare("select * from smart_siswa where id_siswa='".$row['id_siswa']."'");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_siswa'] ?>
				<?php
				}
				?>
            </td>
            <td>
				<?php
				$stmt2 = $db->prepare("select * from smart_mapel where id_mapel='".$row['id_matapelajaran']."'");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_mapel'] ?>
				<?php
				}
				?>
			</td>

			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria where nama_kriteria='keaktifan' ");
            $stmt2x1->execute();
			$row2x1 = $stmt2x1->fetch();
			?>
			<td><?php echo $nilaiKeaktifan = $row['keaktifan'] * $row2x1['bobot_kriteria'] ?></td>

			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria where nama_kriteria='tugas' ");
            $stmt2x1->execute();
			$row2x1 = $stmt2x1->fetch();
			?>
			<td><?php echo $nilaiTugas =  $row['tugas'] * $row2x1['bobot_kriteria'] ?> </td>

			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria where nama_kriteria='kuis' ");
            $stmt2x1->execute();
			$row2x1 = $stmt2x1->fetch();
			?>
            <td><?php echo $nilaiKuis = $row['kuis'] * $row2x1['bobot_kriteria'] ?></td>

			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria where nama_kriteria='uts' ");
            $stmt2x1->execute();
			$row2x1 = $stmt2x1->fetch();
			?>
            <td><?php echo $nilaiUts = $row['uts'] * $row2x1['bobot_kriteria'] ?></td>
			
			<?php
            $stmt2x1 = $db->prepare("select * from smart_kriteria where nama_kriteria='uas' ");
            $stmt2x1->execute();
			$row2x1 = $stmt2x1->fetch();
			?>
            <td><?php echo $nilaiUas = $row['uas'] * $row2x1['bobot_kriteria'] ?></td>
			
			<td><?php echo $nilaiHasil = $nilaiKeaktifan + $nilaiTugas + $nilaiKuis + $nilaiUts + $nilaiUas ?> </td>
			<td><?php 
	            if($nilaiHasil>=80){
	            	echo  "Sangat Paham";
	            } else if($nilaiHasil>=55){
	            	echo  "Paham";
	            } else if($nilaiHasil>=35){
	            	echo  "Kurang Paham";
	            } else{
	            	echo  "Tidak Paham";
	            } ?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
	</table>	
	<p><br/></p>
	</div>
    <script src="js/jquery.js"></script>
    <script src="js/metro.js"></script>
</body>
</html>