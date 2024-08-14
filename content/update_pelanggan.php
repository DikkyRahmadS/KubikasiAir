<div class="row g-5 g-xl-12 mb-xl-12">
    <div class="col-lg-12 col-xl-12 col-xxl-12 mb-5 mb-xl-5">
        <div class="card card-flush overflow-hidden h-md-100">
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                <div class="px-9 mb-5">
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Ubah Data Pelanggan</span>
                    </div>
                </div>
                <div class="min-h-auto ps-4 pe-6">
                    <?php
                    include "koneksi.php"; // Sambungan database

                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $query = "SELECT * FROM users WHERE id = $id";
                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                    ?>
                            <form action="#" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Anda" name="nama" value="<?php echo $row['nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="kota" class="form-label">Kota</label>
                                            <input type="text" class="form-control" id="kota" placeholder="Masukkan Kota Anda" name="kota" value="<?php echo $row['kota']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat Anda" name="alamat" required><?php echo $row['alamat']; ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda" value="<?php echo $row['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengubah password" name="password">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="id_alat" class="form-label">ID Alat</label>
                                            <input type="text" class="form-control" id="id_alat" name="id_alat" placeholder="Masukkan ID Alat Anda (Kosongkan jika tidak ada)" value="<?php echo $row['id_alat']; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="telp" class="form-label">No Telephone</label>
                                            <input type="text" class="form-control" id="telp" placeholder="Masukkan No Telephone Anda" name="telp" value="<?php echo $row['telp']; ?>" required>
                                        </div>
                                    </div>
                                </div>



                                <div class="row mb-10">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="tarif" class="form-label">Tarif per Meter</label>
                                            <select class="form-control" name="tarif" required>
                                                <?php
                                                $query_tarif = "SELECT * FROM tarif_dasar_air";
                                                $result_tarif = mysqli_query($koneksi, $query_tarif);

                                                while ($row_tarif = mysqli_fetch_assoc($result_tarif)) {
                                                    $selected = ($row_tarif['id_tarif'] == $row['id_tarif']) ? 'selected' : '';
                                                    echo "<option value='{$row_tarif['id_tarif']}' {$selected}>{$row_tarif['nama_kelas']} - {$row_tarif['tarif_per_meter']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="level" class="form-label">Level Akun</label>
                                            <select name="level" class="form-control" id="level">
                                                <option value="admin" <?php if ($row['level'] == 'admin') echo 'selected'; ?>>Admin</option>
                                                <option value="user" <?php if ($row['level'] == 'user') echo 'selected'; ?>>User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <center>
                                    <button type="submit" name="update" class="btn btn-primary mb-5">Simpan</button>
                                    <a href="index.php?page=pelanggan" class="btn btn-secondary mb-5">Kembali</a>
                                </center>
                            </form>
                    <?php
                        } else {
                            echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Error!</strong> Data tidak ditemukan.</div>';
                        }
                    }

                    if (isset($_POST['update'])) {
                        $id = $_POST['id'];
                        $nama = $_POST['nama'];
                        $alamat = $_POST['alamat'];
                        $kota = $_POST['kota'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $id_alat = $_POST['id_alat'];
                        $telp = $_POST['telp'];
                        $tarif = $_POST['tarif'];
                        $level = $_POST['level'];

                        // Jika password tidak diubah, gunakan password lama
                        if (empty($password)) {
                            $query = "UPDATE users SET nama='$nama', alamat='$alamat', kota='$kota',telp='$telp', email='$email', id_alat='$id_alat', id_tarif='$tarif', level='$level' WHERE id=$id";
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $query = "UPDATE users SET nama='$nama', alamat='$alamat', kota='$kota',telp='$telp', email='$email', password='$hashed_password', id_alat='$id_alat', id_tarif='$tarif', level='$level' WHERE id=$id";
                        }

                        $result = mysqli_query($koneksi, $query);

                        if ($result) {
                            echo '<script>window.location.href = "index.php?page=pelanggan&success_update=1";</script>';
                        } else {
                            echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Error!</strong> Gagal mengubah data.</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>