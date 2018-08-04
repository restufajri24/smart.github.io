<?php
include "header.php";
$page = isset($_GET['page'])?$_GET['page']:"";
?>
<div class="row cells4">
	<div class="cell colspan2">
		<h3>Mahasiswa</h3>
	</div>
<?php
if($page=='form'){
?>
	<div class="cell colspan2 align-right">
		<a href="mahasiswa.php" class="button info">Kembali</a>
	</div>
</div>
	<p></p>
	<?php
	if(isset($_POST['simpan'])){
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $nim =$_POST['nim'];
        $kelas =$_POST['kelas'];
		$stmt2 = $db->prepare("insert into smart_mahasiswa(id_mahasiswa,nama_mahasiswa,nim,kelas) values('',?,?,?)");
        $stmt2->bindParam(1,$nama_mahasiswa);
        $stmt2->bindParam(2,$nim);
        $stmt2->bindParam(3,$kelas);
		if($stmt2->execute()){
			?>
				<script type="text/javascript">location.href='mahasiswa.php'</script>
			<?php
		} else{
			?>
				<script type="text/javascript">alert('Gagal menyimpan data')</script>
			<?php
		}
	}
	if(isset($_POST['update'])){
		$id_mahasiswa = $_POST['id_mahasiswa'];
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $nim = $_POST['nim'];
        $kelas =$_POST['kelas'];
		$stmt2 = $db->prepare("update smart_mahasiswa set nama_mahasiswa=?, nim=?, kelas=? where id_mahasiswa=?");
        $stmt2->bindParam(1,$nama_mahasiswa);
        $stmt2->bindParam(2,$nim);
        $stmt2->bindParam(3,$kelas);
		$stmt2->bindParam(4,$id_mahasiswa);
		if($stmt2->execute()){
			?>
				<script type="text/javascript">location.href='mahasiswa.php'</script>
			<?php
		} else{
			?>
				<script type="text/javascript">alert('Gagal mengubah data')</script>
			<?php
		}
	}
	?>
	<form method="post">
		<input type="hidden" name="id_mahasiswa" value="<?php echo isset($_GET['id_mahasiswa'])? $_GET['id_mahasiswa'] : ''; ?>">
		<label>Nama mahasiswa</label>
		<div class="input-control text full-size">
		    <input type="text" name="nama_mahasiswa" placeholder="Nama mahasiswa" value="<?php echo isset($_GET['nama_mahasiswa'])? $_GET['nama_mahasiswa'] : ''; ?>">
		</div>
        <label>nim</label>
		<div class="input-control text full-size">
		    <input type="text" name="nim" placeholder="nim" value="<?php echo isset($_GET['nim'])? $_GET['nim'] : ''; ?>">
		</div>
        <label>kelas</label>
		<div class="input-control text full-size">
		    <input type="text" name="kelas" placeholder="kelas" value="<?php echo isset($_GET['kelas'])? $_GET['kelas'] : ''; ?>">
		</div>
		<?php
		if (isset($_GET['id_mahasiswa'])) {
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
	if(isset($_GET['id_mahasiswa'])){
		$stmt = $db->prepare("delete from smart_mahasiswa where id_mahasiswa='".$_GET['id_mahasiswa']."'");
	 	if($stmt->execute()){
	 		?>
	 		<script type="text/javascript">location.href='mahasiswa.php'</script>
	 		<?php
	 	}
	}
} else{
?>
	<div class="cell colspan2 align-right">
		<a href="?page=form" class="button primary">Tambah</a>
	</div>
</div>
<table class="table striped hovered cell-hovered border bordered dataTable" data-role="datatable" data-searching="true">
	<thead>
		<tr>
			<th width="50">ID</th>
			<th>Nama mahasiswa</th>
            <th>nim</th>
            <th>kelas</th>
			<th width="240">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$stmt = $db->prepare("select * from smart_mahasiswa");
		$stmt->execute();
        $no = 1;
		while($row = $stmt->fetch()){
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $row['nama_mahasiswa'] ?></td>
            <td><?php echo $row['nim'] ?></td>
            <td><?php echo $row['kelas'] ?></td>
			<td class="align-center">
            <a href="?page=form&id_mahasiswa=<?php echo $row['id_mahasiswa'] ?>&nama_mahasiswa=<?php echo $row['nama_mahasiswa'] ?>&nim=<?php echo $row['nim'] ?>&kelas=<?php echo $row['kelas'] ?>" class="button warning"><span class="mif-pencil icon"></span> Edit</a>
				<a href="?page=hapus&id_mahasiswa=<?php echo $row['id_mahasiswa'] ?>" class="button danger"><span class="mif-cancel icon"></span> Hapus</a>
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
					
					