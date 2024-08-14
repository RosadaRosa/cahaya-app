<!DOCTYPE html>
<html>

<head>
    <title>Struk Penjualan</title>
    <style>
        /* Aturan umum untuk tampilan layar */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .details,
        .total {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px; /* Sesuaikan padding untuk struk kecil */
            text-align: left;
            font-size: 10px; /* Sesuaikan ukuran font untuk struk kecil */
        }

        th {
            background-color: #f4f4f4;
        }

        /* Aturan untuk media cetak */
        @media print {
            @page {
                size: 80mm 297mm; /* Sesuaikan ukuran kertas struk di sini */
                margin: 0; /* Hilangkan margin default */
            }

            body {
                font-size: 10px; /* Sesuaikan ukuran font lebih kecil untuk struk */
                margin: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 2px; /* Padding lebih kecil untuk struk */
                font-size: 10px; /* Ukuran font lebih kecil untuk struk */
            }

            .header img {
                width: 100px; /* Sesuaikan lebar logo */
                height: auto;
            }

            .footer {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
        <h2>STRUK PENJUALAN</h2>
        <h3>TOKO CAHAYA - APP</h3>
        <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
        <p>No. Hp/WA : 089530594535</p>
    </div>
    <p>Nama Pelanggan: <?= $transaksi->nama_pelanggan; ?></p>
    <p>Tanggal: <?= $transaksi->tanggal_input; ?></p>
    <p>Kasir: <?= $transaksi->nama_lengkap; ?></p>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga Jual</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($items as $item) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['barang']->merk ?> - <?= $item['barang']->bahan ?> - <?= $item['barang']->ukuran ?></td>
                    <td><?= $item['jumlah']; ?></td>
                    <td><?= $item['harga_jual']; ?></td>
                    <td><?= $item['jumlah'] * $item['harga_jual']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <p>Diskon: <?= $transaksi->diskon; ?></p>
    <p>Total: <?= $transaksi->total; ?></p>
    <p>Bayar: <?= $transaksi->bayar; ?></p>
    <p>Kembalian: <?= $transaksi->kembalian; ?></p>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
    </div>
</body>

</html>