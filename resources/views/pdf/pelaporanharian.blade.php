<html>
<head>
    <style>

    </style>
</head>
<body>
<div style="background-color: #0e0d12;color: white;font-size: 30px;text-align: center">
    Laporan Harian
</div>
<table style="width: 100%;margin-top: 40px">
    <tr style="width: 100%;">
        <td style="width: 50%;text-align: left">
            Klinik Dokter Gunawan<br>
            Jl. Projosunmarto II No.2
        </td>
        <td style="width: 50%;text-align: right">
            {{$data['first']}} - {{$data['last']}}
        </td>
    </tr>
</table>

<h2>Daftar Pemeriksaan</h2>

<table border="1" style="width: 100%;">
    <tr style="width: 100%;">
        <td>
            NO
        </td>
        <td>
            Pasien
        </td>
        <td>
            Dokter
        </td>
        <td>
            Keluhan
        </td>
    </tr>
    @foreach($data['pemeriksaans'] as $pemeriksaan)
        <tr style="width: 100%;">
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                {{$pemeriksaan->pasien->nama}}
            </td>
            <td>
                {{$pemeriksaan->dokter->nama}}
            </td>
            <td>
                {{$pemeriksaan->keluhan}}
            </td>
        </tr>
    @endforeach
</table>

<h2>Daftar Pasien</h2>

<table border="1" style="width: 100%;">
    <tr style="width: 100%;">
        <td>
            NO
        </td>
        <td>
            Nama
        </td>
        <td>
            Umur
        </td>
        <td>
            Jenis Kelamin
        </td>
        <td>
            Total Pemeriksaan
        </td>
    </tr>
    @foreach($data['pasiens'] as $pasien)
        <tr style="width: 100%;">
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                {{$pasien->nama}}
            </td>
            <td>
                {{$pasien->umur}}
            </td>
            <td>
                {{$pasien->gender}}
            </td>
            <td>
                {{$pasien->total}}
            </td>
        </tr>
    @endforeach
</table>

<h2>Daftar Keluhan</h2>

<table border="1" style="width: 100%;">
    <tr style="width: 100%;">
        <td>
            NO
        </td>
        <td>
            Keluhan
        </td>
        <td>
            Total
        </td>
        <td>
            Pasien
        </td>
    </tr>
    @foreach($data['keluhans'] as $keluhan)
        <tr style="width: 100%;">
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                {!! $keluhan['keluhan'] !!}
            </td>
            <td>
                {!! $keluhan['jumlah'] !!}
            </td>
            <td>
                {!! implode(',',$keluhan['pasiens']) !!}
            </td>
        </tr>
    @endforeach
</table>


</body>
</html>
