<?php
include "header.php";
$page = isset($_GET['page'])?$_GET['page']:"";
?>
<div class="row cells4">
	<div class="cell colspan2">
		<h3>Perangkingan</h3>
	</div>
<?php
if($page=='form'){
?>
	<div class="cell colspan2 align-right">
		<a href="perangkingan.php" class="button info">Kembali</a>
	</div>
</div>
	<p></p>
	<?php
	if(isset($_POST['simpan'])){
		$mhs = $_POST['id_mahasiswa'];
		$stmtx4 = $db->prepare("select * from smart_mahasiswa");
		$stmtx4->execute();
		while($rowx4 = $stmtx4->fetch()){
			if ($rowx4['id_mahasiswa']==true) {
				$idmhs = $rowx4['id_mahasiswa'];
				$kri = $_POST['kri'][$idkri];
				$altkri = $_POST['altkri'][$idkri];
				$id_divisi =$_POST['id_divisi'];
        		$id_mahasiswa = $_POST['id_mahasiswa'];
				$stmt2 = $db->prepare("insert into smart_alternatif_kriteria(id_kriteria,id_divisi,id_mahasiswa) values(?,?,?)");
				$stmt2->bindParam(1,$kri);
				$stmt2->bindParam(2,$id_divisi);
        		$stmt2->bindParam(3,$id_mahasiswa);
				$stmt2->execute();

				$id_mahasiswa = $rowx4['id_mahasiswa'];
				$altkri = $_POST['altkri'][$idkri];
				$nilai_kri =$_POST['nilai_kriteria'];
				$stmt3 = $db->prepare("insert into smart_detail_nilai(id_mahasiswa,id_alternatif_kriteria,nilai_kriteria) values(?,?,?)");
				$stmt3->bindParam(1,$id_mahasiswa);
				$stmt3->bindParam(2,$id_alternatif_kriteria);
        		$stmt3->bindParam(3,$nilai_kri);
				$stmt3->execute();
			}
		}
	}
	if(isset($_POST['update'])){
		$mhs = $_POST['altkri'];
		$stmtx4 = $db->prepare("select * from smart_alternatif_kriteria");
		$stmtx4->execute();
		while($rowx4 = $stmtx4->fetch()){
			if ($rowx4['id_kriteria']==true) {
				$idkri = $rowx4['id_kriteria'];
				$kri = $_POST['kri'][$idkri];
				$altkri = $_POST['altkri'][$idkri];
				$id_divisi =$_POST['id_divisi'];
        		$id_mahasiswa = $_POST['id_mahasiswa'];
				$stmt2 = $db->prepare("insert into smart_alternatif_kriteria(id_kriteria,id_divisi,id_mahasiswa) values(?,?,?)");
				$stmt2->bindParam(1,$kri);
				$stmt2->bindParam(2,$id_divisi);
        		$stmt2->bindParam(3,$id_mahasiswa);
				$stmt2->execute();
			}
		}
	}
	?>
	<form method="post">
		<label>Nama Mahasiwa</label>
		<div class="input-control select full-size">
		    <select name="id_mahasiswa">
		    	<option value="<?php echo isset($_GET['id_mahasiswa'])? $_GET['id_mahasiswa'] : ''; ?>"><?php echo isset($_GET['id_mahasiswa'])? $_GET['id_mahasiswa'] : ''; ?></option>
		    	<?php
				$stmt2 = $db->prepare("select * from smart_mahasiswa");
				$stmt2->execute();
				while($row3 = $stmt2->fetch()){
				?>
		    	<option value="<?php echo $row3['id_mahasiswa'] ?>"><?php echo $row3['nama_mahasiswa'] ?></option>
		    	<?php
		    	}
		    	?>
		    </select>
		</div>
		<label>Divisi</label>
		<div class="input-control text full-size">
        <select name="id_divisi">
		    	<option value="<?php echo isset($_GET['id_divisi'])? $_GET['id_divisi'] : ''; ?>"><?php echo isset($_GET['id_divisi'])? $_GET['id_divisi'] : ''; ?></option>
		    	<?php
				$stmt2 = $db->prepare("select * from smart_divisi");
				$stmt2->execute();
				while($row3 = $stmt2->fetch()){
				?>
		    	<option value="<?php echo $row3['id_divisi'] ?>"><?php echo $row3['nama_divisi'] ?></option>
		    	<?php
		    	}
		    	?>
		    </select>
		</div>
		<br/><br/><b>
		<div class="row cells3">
			<div class="cell">ID Kriteria</div>
			<div class="cell colspan2">Nilai/Sub Kriteria</div>
		</div>
	</b><br/>
		<?php
			$stmt4 = $db->prepare("select * from smart_kriteria");
			$stmt4->execute();
			$no=1;
			while($row4 = $stmt4->fetch()){
		?>
		<div class="row cells3">
			<div class="cell"><input type="hidden" name="kri[<?php echo $row4['id_kriteria'] ?>]" value="<?php echo $row4['id_kriteria'] ?>"><?php echo $no++ ?>.
				<?php echo $row4['nama_kriteria'] ?></div>
			<div class="cell colspan2">
				<div class="input-control select full-size">
				    <select name="altkri[<?php echo $row4['id_kriteria'] ?>]">
				    	<?php
						$stmt5 = $db->prepare("select * from smart_sub_kriteria where id_kriteria='".$row4['id_kriteria']."'");
						$stmt5->execute();
						while($row5 = $stmt5->fetch()){
						?>
				    	<option value="<?php echo $row5['nilai_sub_kriteria'] ?>"><?php echo $row5['nama_sub_kriteria'] ?></option>
				    	<?php
				    	}
				    	?>
				    </select>
				</div>
			</div>
		</div>
		<?php
		    }
		?>
		<?php
		if (isset($_GET['id'])) {
			?>
			<button type="submit" name="update" class="button warning">Update</button>
			<?php
		} else{
			?>
			<button type="submit" name="simpan" class="button primary">Simpan</button>
			<?php
		}
		?>
	</form>
<?php
} else if($page=='hapus'){
?>
	<div class="cell colspan2 align-right">
	</div>
</div>
<?php
	if(isset($_GET['mhs'])){
		$stmt = $db->prepare("delete from smart_alternatif_kriteria where id_mahasiswa='".$_GET['mhs']."'");
	 	if($stmt->execute()){
	 		?>
	 		<script type="text/javascript">location.href='perangkingan.php'</script>
	 		<?php
	 	}
	}
} else{
?>
	<div class="cell colspan2 align-right">
		<a href="nilai_ultility.php" class="button success">Nilai Ultility</a>
		<a href="?page=form" class="button primary">Tambah</a>
	</div>
</div>
<table class="table striped hovered cell-hovered border bordered dataTable" data-role="datatable" data-searching="true">
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
			<th width="140">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$stmt = $db->prepare("select * from smart_alternatif_kriteria");
		$nox = 1;
		$stmt->execute();
		$stmt2->execute();
		while($row = $stmt->fetch()){
		?>
		<tr>
			<td><?php echo $nox++ ?></td>
			<td>
				<?php
				$stmt2 = $db->prepare("select * from smart_alternatif_kriteria sak join smart_mahasiswa sm on sak.id_mahasiswa = sm.id_mahasiswa");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_mahasiswa'] ?>
				<?php
				}
				?>
			</td>
			<td>
				<?php
				$stmt2 = $db->prepare("select * from smart_alternatif_kriteria sak join smart_divisi sd on sak.id_divisi = sd.id_divisi");
				$stmt2->execute();
				while($row2 = $stmt2->fetch()){
				?>
				<?php echo $row2['nama_divisi'] ?>
				<?php
				}
				?>
			</td>
            <?php
            $stmt3 = $db->prepare("select * from smart_kriteria");
            $stmt3->execute();
            while($row3 = $stmt3->fetch()){
            ?>
			<td>
                <?php
                $stmt4 = $db->prepare("select * from smart_alternatif_kriteria sak join smart_detail_nilai sdn on sak.id_alternatif_kriteria=sdn.id_alternatif_kriteria");
                $stmt4->execute();
                while($row4 = $stmt4->fetch()){
                    echo $row4['nilai_kriteria'];
                    ?>
                    <!--<a href="?page=form&alt=<?php echo $row['id_mahasiswa'] ?>&kri=<?php echo $row3['id_kriteria'] ?>&nilai=<?php echo $row4['nilai_alternatif_kriteria'] ?>" style="color:orange"><span class="mif-pencil icon"></span></a>-->
                    <?php
                }
                ?>
            </td>
            <?php
            }
            ?>
			<td class="align-center">
				<a href="?page=hapus&mhs=<?php echo $row['id_mahasiswa'] ?>" class="button danger"><span class="mif-cancel icon"></span> Hapus</a>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<p><br/></p>
<?php
}
include "footer.php";
?>
					
					