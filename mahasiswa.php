<?php
$koneksi = mysqli_connect("localhost", "root", "", "mahasiswa_1");
if (isset($_POST['simpan'])) {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama_mhs = mysqli_real_escape_string($koneksi, $_POST['nama_mhs']);

    // Menggunakan Prepared Statements untuk mencegah SQL Injection
    $prepared = mysqli_prepare($koneksi, "INSERT INTO data_mahasiswa (nim, nama_mhs) VALUES (?, ?)");
    mysqli_stmt_bind_param($prepared, 'ss', $nim, $nama_mhs);
    mysqli_stmt_execute($prepared);
    mysqli_stmt_close($prepared);
}

// Proses sorting berdasarkan input dari form
$order = 'ASC';
if (isset($_POST['sortaz'])) {
    $order = 'ASC';
} elseif (isset($_POST['sortza'])) {
    $order = 'DESC';
}

$data_mahasiswa = mysqli_query($koneksi, "SELECT * FROM data_mahasiswa ORDER BY nama_mhs $order");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript">
        function isikolom() {
            var nim = document.getElementsByName('nim')[0].value;
            var nama_mhs = document.getElementsByName('nama_mhs')[0].value;
            if (nim == "" || nama_mhs == "") {
                alert('Lengkapi data terlebih dahulu!');
                return false;
            } else {
                alert('Data berhasil ditambahkan!');
                return true;
            }
        }
    </script>
</head>

<body class="bg-slate-100">
    <header class="m-8">
        <h1 class="font-inter text-4xl font-normal leading-5 text-center">Data Mahasiswa</h1>
    </header>
    <hr class="border-b mt-4">
    <div class="flex items-center w-full">
        <form class="w-full" action="" onsubmit="return isikolom()" method="post">
            <table class="w-full ml-4">
                <tr>
                    <td><input class="input-field m-2 p-2 border border-black rounded-lg w-full" type="text"
                            name="nim" placeholder="NIM"></td>
                    <td><input class="input-field m-2 p-2 border border-black rounded-lg w-full" type="text"
                            name="nama_mhs" placeholder="Nama Mahasiswa"></td>
                    <td><input class="bg-blue-500 m-2 text-white p-2 rounded-lg" type="submit" name="simpan"
                            value="Proses"></td>
                </tr>
            </table>
        </form>
        <form action="" method="post">
            <table class="w-1/2">
                <tr>
                    <td><input class="bg-slate-400 text-white p-2 rounded-lg" type="submit" name="sortaz"
                            value="Sort A-Z"></td>
                </tr>
            </table>
        </form>
        <form class="mx-4" action="" method="post">
            <table class="w-1/2">
                <tr>
                    <td><input class="bg-slate-400 text-white p-2 rounded-lg" type="submit" name="sortza"
                            value="Sort Z-A"></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="flex mt-2">
        <table class="border-collapse mx-4 w-full" border="1">
            <thead class="bg-blue-500 border-b text-white">
                <th class="font-bold border text-left w-10 p-2">No</th>
                <th class="font-bold border text-left w-10 p-2">NIM</th>
                <th class="font-bold border text-left w-10 p-2">Nama Mahasiswa</th>
            </thead>
            <?php
            $no = 1;
            while ($tampil_mhs = mysqli_fetch_array($data_mahasiswa)) {
                ?>
                <tr>
                    <td class="border p-2"><?= $no++; ?>.</td>
                    <td class="border p-2"><?= $tampil_mhs['nim']; ?></td>
                    <td class="border p-2"><?= $tampil_mhs['nama_mhs']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>