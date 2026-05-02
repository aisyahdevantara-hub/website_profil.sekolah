<?php 
    include '../koneksi.php';
    if(isset($_GET['idpengguna'])){
        $delete = mysqli_query($conn, "DELETE FROM pengguna WHERE id = '".$_GET['idpengguna']."' ");
        echo "<script>window.location='pengguna.php?success=Data Berhasil Dihapus'</script>";
    }


    if(isset($_GET['idguru'])){
        
        $guru = mysqli_query($conn, "SELECT gambar FROM guru WHERE id = '".$_GET['idguru']."' ");

        if(mysqli_num_rows($guru) > 0){
            $p = mysqli_fetch_object($guru);
            if(file_exists("../uploads/guru/" .$p->gambar)){
                unlink("../uploads/guru/" .$p->gambar);
            }
        }
        $delete = mysqli_query($conn, "DELETE FROM guru WHERE id = '".$_GET['idguru']."' ");
        echo "<script>window.location='guru.php?success=Data Berhasil Dihapus'</script>";
    }

    if(isset($_GET['idfasilitas'])){
    $fasilitas = mysqli_query($conn, "SELECT foto FROM fasilitas WHERE id = '".$_GET['idfasilitas']."' ");

    if(mysqli_num_rows($fasilitas) > 0){
        $p = mysqli_fetch_object($fasilitas);
        if(file_exists("../uploads/fasilitas/" .$p->foto)){
            unlink("../uploads/fasilitas/" .$p->foto);
        }
    }

    $delete = mysqli_query($conn, "DELETE FROM fasilitas WHERE id = '".$_GET['idfasilitas']."' ");

    echo "<script>window.location='fasilitas.php?success=Data Berhasil Dihapus'</script>";
    }

    if(isset($_GET['idkegiatan'])){
    $kegiatan = mysqli_query($conn, "SELECT gambar FROM kegiatan WHERE id = '".$_GET['idkegiatan']."' ");

    if(mysqli_num_rows($kegiatan) > 0){
        $p = mysqli_fetch_object($kegiatan);
        
        if(file_exists("../uploads/kegiatan/" .$p->gambar)){
            unlink("../uploads/kegiatan/" .$p->gambar);
        }
    }

    $delete = mysqli_query($conn, "DELETE FROM kegiatan WHERE id = '".$_GET['idkegiatan']."' ");

    echo "<script>window.location='kegiatan.php?success=Data Berhasil Dihapus'</script>";
}
?>