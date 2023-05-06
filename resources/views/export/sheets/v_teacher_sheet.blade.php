<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guru</title>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">slug</td>
                <td style="text-align: center; font-size:10px">nip</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">phone</td>
                <td style="text-align: center; font-size:10px">address</td>
            </thead>
        </table>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Kode</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">NIP</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Telepon</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Alamat</td>
            </thead>
        </table>
        <tbody>
            @foreach ($data as $guru)
                <tr>
                    <td style="font-size:10px; text-align: center;">{{ $guru['slug'] }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $guru['nip'] }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $guru['name'] }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $guru['phone'] }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $guru['address'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </div>
</body>

</html>
