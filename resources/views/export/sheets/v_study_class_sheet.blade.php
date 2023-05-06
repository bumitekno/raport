<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rombel</title>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">slug</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">level</td>
                <td style="text-align: center; font-size:10px">major</td>
            </thead>
        </table>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Code</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Kelas</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Jurusan</td>
            </thead>
        </table>
        <tbody>
            @foreach ($data as $rombel)
                <tr>
                    <td style="font-size:10px; text-align: center;">{{ $rombel->slug }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $rombel->name }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $rombel->level }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $rombel->major }}</td>
                </tr>
            @endforeach
        </tbody>
    </div>
</body>

</html>
