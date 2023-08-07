<html>
<head>
    <style>

    </style>
</head>
<body>
<div style="background-color: #0e0d12;color: white;font-size: 30px;text-align: center">
    INVOICE
</div>
<table style="width: 100%;margin-top: 40px">
    <tr style="width: 100%;">
        <td style="width: 50%;text-align: left">
            Klinik Dokter Gunawan<br>
            Jl. Projosunmarto II No.2
        </td>
        <td style="width: 50%;text-align: right">
            {{$pemeriksaan->hari}}<br>
            pasien : {{$pemeriksaan->pasien->nama}}
        </td>
    </tr>
</table>

<table border="1" style="width: 100%;margin-top: 40px">
    <tr style="width: 100%;">
        <td>
            NO
        </td>
        <td>
            Obat
        </td>
        <td>
            Jumlah
        </td>
        <td>
            Harga
        </td>
        <td>
            Total
        </td>
    </tr>
    @php
        $grand = 0;
    @endphp
    @foreach($pemeriksaan->racikan as $racikan)
        <tr style="width: 100%;">
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                {{$racikan->obat->nama}}
            </td>
            <td>
                {{$racikan->jumlah}}
            </td>
            <td>
                Rp. {{$racikan->obat->harga}}
            </td>
            <td>
                Rp. {{$racikan->obat->harga * $racikan->jumlah}}
            </td>
            @php
                $grand = $grand + $racikan->obat->harga * $racikan->jumlah;
            @endphp
        </tr>
    @endforeach
</table>
<div style="margin-top: 40px;text-align: left">
    Total Yang Harus Dibayar : Rp. {{$grand}}
</div>
<div style="margin-top: 40px;text-align: right">
    Hormat Kami
    <br>
    <br>
    <br>
    <br>
    Admin
</div>
</body>
</html>
