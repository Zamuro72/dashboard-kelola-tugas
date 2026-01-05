<h1 align="center">Data Tugas</h1>
<h3 align="center">Tanggal : {{ $tanggal }}</h3>
<h3 align="center">Pukul : {{ $jam }}</h3>
<hr>
<table width="100%">
<tbody>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{ $tugas->user->nama }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td>{{ $tugas->user->email }}</td>
    </tr>
    <tr>
        <td>Tugas</td>
        <td>:</td>
        <td>{{ $tugas->tugas }}</td>
    </tr>
    <tr>
        <td>Tanggal Mulai</td>
        <td>:</td>
        <td>{{ $tugas->tanggal_mulai }}</td>
    </tr>
    <tr>
        <td>Tanggal Selesai</td>
        <td>:</td>
        <td>{{ $tugas->tanggal_selesai }}</td>
    </tr>
</tbody>
</table>
<hr>