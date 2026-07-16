<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Invoice Reservasi Terapi</title>

<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    @page{
        margin:10mm;
    }

    body{
        font-family: Arial, Helvetica, sans-serif;
        font-size:14px;
        color:#333;
        background:#fff;
    }

    .invoice-wrapper{
        width:100%;
        border:1px solid #e5e5e5;
        padding:25px;
    }

    /* HEADER */

    .header-table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:30px;
        border-bottom:2px solid #4CAF50;
        padding-bottom:15px;
    }

    .brand-cell{
        width:60%;
        vertical-align:top;
        text-align:left;
    }

    .invoice-cell{
        width:40%;
        vertical-align:top;
        text-align:right;
    }

    .brand-cell h1{
        font-size:28px;
        color:#4CAF50;
        margin-bottom:5px;
    }

    .brand-cell p{
        font-size:13px;
        color:#666;
        line-height:20px;
    }

    .invoice-cell h2{
        font-size:32px;
        color:#333;
        margin-bottom:10px;
    }

    .invoice-num{
        font-size:18px;
        color:#4CAF50;
        font-weight:bold;
        margin-bottom:5px;
    }

    .date{
        color:#777;
        font-size:13px;
    }

    /* BADGE */

    .badge{
        display:inline-block;
        padding:5px 12px;
        font-size:11px;
        font-weight:bold;
        border-radius:20px;
    }

    .badge-success{
        background:#a0ffa8;
        color:#2e7d32;
    }
    
    .badge-danger{
        background:#ffc2c2;
        color:#bd1d1d;
    }

    /* INFO */

    .info-table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:30px;
    }

    .info-box{
        width:48%;
        background:#f9f9f9;
        padding:15px;
        border-left:4px solid #4CAF50;
        vertical-align:top;
    }

    .info-box h3{
        font-size:13px;
        color:#777;
        margin-bottom:10px;
        text-transform:uppercase;
    }

    .info-box p{
        margin-bottom:6px;
        line-height:20px;
    }

    .label{
        font-weight:bold;
    }

    /* ITEM TABLE */

    .items-table{
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }

    .items-table thead tr{
        background:#4CAF50;
    }

    .items-table th{
        color:#fff;
        padding:12px;
        font-size:12px;
        text-transform:uppercase;
        text-align:left;
    }

    .items-table td{
        padding:12px;
        border-bottom:1px solid #eaeaea;
        vertical-align:top;
    }

    .text-right{
        text-align:right;
    }

    .items-table tfoot td{
        font-weight:bold;
        background:#fafafa;
    }

    /* FOOTER */

    .footer{
        margin-top:30px;
        border-top:1px solid #ddd;
        padding-top:20px;
        text-align:center;
    }

    .footer p{
        line-height:22px;
        color:#666;
    }

    .thank-you{
        margin-top:15px;
        font-size:16px;
        color:#4CAF50;
        font-weight:bold;
    }
</style>

</head>
<body>

<div class="invoice-wrapper">

    <!-- HEADER -->

    <table class="header-table">
        <tr>

            <td class="brand-cell">
                <h1 class="text-3xl font-bold text-green-600 tracking-wide">
                    <img src="file:///{{ str_replace('\\', '/', public_path('assets/img/logo-landscape.png')) }}"
                    alt="Logo"
                    style="width:190px;">
                </h1>

                <p class="text-sm text-gray-500">
                Perum. Taman Permata Hijau Blok E11,<br>
                Kel. Kebalenan, Kec. Banyuwangi,<br>
                Banyuwangi, Jawa Timur 68417
                </p>
            </td>

            <td class="invoice-cell">

                <h2>INVOICE</h2>

                <div class="invoice-num">
                    #{{substr($transaksi->order_id,0,11)}}
                </div>

                <div class="date">
                    Tanggal: {{ dateId('j F Y',$transaksi->created_at) }}
                </div>

                <div style="margin-top:10px;">
                    <span
                        class=" badge
                        @if ($transaksi->status == 'paid')
                            badge-success
                        @else
                            badge-danger
                        @endif">
                        {{$transaksi->status == 'paid' ? 'Lunas' : 'Belum Lunas'}}
                    </span>
                </div>

            </td>

        </tr>
    </table>

    <!-- INFORMASI -->

    <table class="info-table">
        <tr>

            <td class="info-box">

                <h3>Data Pasien</h3>

                <p>
                    <span class="label">Nama:</span>
                    {{$transaksi->nama}}
                </p>

                <p>
                    <span class="label">No. HP:</span>
                    {{$transaksi->nohp}}
                </p>

                <p>
                    <span class="label">Jenis Kelamin:</span>
                     {{$transaksi->jenis_kelamin == 'L' ? 'Laki-laki':'Perempuan'}}
                </p>

            </td>

            <td width="20"></td>

            <td class="info-box">

                <h3>Detail Reservasi</h3>

                <p>
                    <span class="label">Terapis:</span>
                    Putriyani
                </p>

                <p>
                    <span class="label">Jadwal:</span>
                    {{dateId('j F Y',$transaksi->tanggal).', '.$transaksi->jam}} WIB
                </p>

                <p>
                    <span class="label">Layanan:</span>
                    {{$transaksi->tempat == 'center' ? 'Treatment Center':'Homecare'}}
                </p>

            </td>

        </tr>
    </table>

    <!-- DETAIL LAYANAN -->

    <table class="items-table">

        <thead>
            <tr>
                <th>Layanan Terapi</th>
                <th>Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>

        <tbody>

            <tr>

                <td>
                    <strong>{{$jenis_terapi->jenis_terapi.' '.$transaksi->nama_terapi}}</strong>
                </td>

                <td>{{$transaksi->jumlah}}</td>

                <td class="text-right">
                    {{rupiah($transaksi->total_harga)}}
                </td>

                <td class="text-right">
                    {{rupiah($transaksi->total_harga)}}
                </td>

            </tr>

        </tbody>

        <tfoot>

            <tr>
                <td colspan="3" class="text-right">
                    Subtotal
                </td>
                <td class="text-right">
                    {{rupiah($transaksi->total_harga)}}
                </td>
            </tr>

            <tr>
                {{-- <td colspan="3" class="text-right">
                    Pajak (10%)
                </td>
                <td class="text-right">
                    Rp 15.000
                </td> --}}
            </tr>

            <tr>
                <td colspan="3" class="text-right">
                    TOTAL PENAGIHAN
                </td>
                <td class="text-right" style="color:#4CAF50;">
                    {{rupiah($transaksi->total_harga)}}
                </td>
            </tr>

        </tfoot>

    </table>

    <!-- FOOTER -->

    <div class="footer">

        <p>
            <strong>Catatan:</strong>
            Pembayaran dilakukan maksimal H-1 sebelum jadwal terapi.
            Bukti transfer dikirim melalui WhatsApp resmi klinik.
        </p>

        <div class="thank-you">
            TERIMA KASIH ATAS KEPERCAYAAN ANDA
        </div>

        <p style="font-size:12px;margin-top:15px;color:#999;">
            Invoice ini sah tanpa tanda tangan karena dibuat secara elektronik.
        </p>

    </div>

</div>

</body>
</html>