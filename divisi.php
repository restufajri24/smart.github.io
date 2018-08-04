<?php
include "header.php";
$page = isset($_GET['page'])?$_GET['page']:"";
?>
<div class="row cells4">
	<div class="cell colspan2">
		<h3>Divisi</h3>
	</div>
<?php
if($page=='form'){
?>
	<div class="cell colspan2 align-right">
		<a href="divisi.php" class="button info">Kembali</a>
	</div>
</div>
	<p></p>
	<?php
	if(isset($_POST['simpan'])){
        $nama_divisi = $_POST['nama_divisi'];
        $kepala_divisi =$_POST['kepala_divisi'];
		$stmt2 = $db->prepare("insert into smart_divisi(id_divisi,nama_divisi,kepala_divisi) values('',?,?)");
        $stmt2->bindParam(1,$nama_divisi);
        $stmt2->bindParam(2,$kepala_divisi);
		if($stmt2->execute()){
			?>
				<script type="text/javascript">location.href='divisi.php'</script>
			<?php
		} else{
			?>
				<script type="text/javascript">alert('Gagal menyimpan data')</script>
			<?php
		}
	}
	if(isset($_POST['update'])){
		$id_divisi = $_POST['id_divisi'];
        $nama_divisi = $_POST['nama_divisi'];
        $kepala_divisi =$_POST['kepala_divisi'];
		$stmt2 = $db->prepare("update smart_divisi set nama_divisi=?, kepala_divisi=? where id_divisi=?");
        $stmt2->bindParam(1,$nama_divisi);
        $stmt2->bindParam(2,$kepala_divisi);
		$stmt2->bindParam(3,$id_divisi);
		if($stmt2->execute()){
			?>
				<script type="text/javascript">location.href='divisi.php'</script>
			<?php
		} else{
			?>
				<script type="text/javascript">alert('Gagal mengubah data')</script>
			<?php
		}
	}
	?>
	<form method="post">
		<input type="hidden" name="id_divisi" value="<?php echo isset($_GET['id_divisi'])? $_GET['id_divisi'] : ''; ?>">
		<label>DIVISI</label>
		<div class="input-control text full-size">
		    <input type="text" name="nama_divisi" placeholder="Divisi" value="<?php echo isset($_GET['nama_divisi'])? $_GET['nama_divisi'] : ''; ?>">
		</div>
        <label>Kepala Divisi</label>
		<div class="input-control text full-size">
		    <input type="text" name="kepala_divisi" placeholder="Kepala Divisi" value="<?php echo isset($_GET['kepala_divisi'])? $_GET['kepala_divisi'] : ''; ?>">
		</div>
		<?php
		if (isset($_GET['id_divisi'])) {
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
	if(isset($_GET['id_divisi'])){
		$stmt = $db->prepare("delete from smart_divisi where id_divisi='".$_GET['id_divisi']."'");
	 	if($stmt->execute()){
	 		?>
	 		<script type="text/javascript">location.href='divisi.php'</script>
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
			<th>Divisi</th>
            <th>Kepala Divisi</th>
			<th width="240">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$stmt = $db->prepare("select * from smart_divisi");
		$stmt->execute();
        $no = 1;
		while($row = $stmt->fetch()){
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $row['nama_divisi'] ?></td>
            <td><?php echo $row['kepala_divisi'] ?></td>
			<td class="align-center">
            <a href="?page=form&id_divisi=<?php echo $row['id_divisi'] ?>&nama_divisi=<?php echo $row['nama_divisi'] ?>&kepala_divisi=<?php echo $row['kepala_divisi'] ?>" class="button warning"><span class="mif-pencil icon"></span> Edit</a>
				<a href="?page=hapus&id_divisi=<?php echo $row['id_divisi'] ?>" class="button danger"><span class="mif-cancel icon"></span> Hapus</a>
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
					
					