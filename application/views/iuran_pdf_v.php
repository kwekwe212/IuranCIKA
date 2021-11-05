<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .text-center {
        text-align: center;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    table,
    th,
    td {
        border: 1px solid black;
        padding: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        font-weight: bold;
        width: 20%;
    }

    .total {
        margin-top: 30px;
        margin-left: 550px;
    }
</style>



<h2>Laporan Iuran</h2>
<table>
    <tr>
        <th>Nama</th>
        <th>Iuran Wajib</th>
        <th>Iuran Sampingan</th>
        <th>Iuran Total</th>
        <th>Tanggal</th>
    </tr>
    <?php foreach ($data as $a) : ?>
        <tr>
            <td><?= $a['name'] ?></td>
            <td class="text-center"><?= rupiah($a['iuran_wajib']) ?></td>
            <td class="text-center"><?= rupiah($a['iuran_sampingan']) ?></td>
            <td class="text-center"><?= rupiah($a['iuran_total']) ?></td>
            <td class="text-center"><?= date("d-m-Y", strtotime($a['date'])) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="total">
    <h5>Jumlah iuran</h5>
    <p><?= rupiah($total) ?></p>
</div>