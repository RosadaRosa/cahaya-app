<?php
// Tambahkan kondisi untuk mengecek apakah $responden telah di-set
if (isset($responden) && is_array($responden) && count($responden) > 0) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Responden</title>
    <!-- Tambahkan gaya atau tag meta yang diperlukan untuk pencetakan -->
    <style>
        /* Tambahkan gaya pencetakan Anda di sini */
    </style>
</head>
<body>
    <table>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Komoditas</th>
        </tr>
        <?php
        $no = 1;
        foreach ($responden as $row) : ?>
            <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->bulan; ?></td>
                    <td><?= $row->nama; ?></td>
                    <td><?= $row->alamat; ?></td>
                    <td><?= $row->komoditas; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script type="text/javascript">
        // Gunakan JavaScript untuk memicu dialog pencetakan saat halaman dimuat
        window.onload = function() {
            window.print();
            // Tutup jendela setelah mencetak (opsional)
            window.onafterprint = function(){
                window.close();
            };
        };
    </script>
</body>
</html>
<?php
} else {
    echo "Tidak ada data yang dicetak.";
}
?>
