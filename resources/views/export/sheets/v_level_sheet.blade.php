<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tingkat</title>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">slug</td>
                <td style="text-align: center; font-size:10px">name</td>
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
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Tingkat</td>
            </thead>
        </table>
        <tbody>
            @foreach ($data as $level)
                <tr>
                    <td style="font-size:10px; text-align: center;">{{ $level->slug }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $level->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </div>
</body>

</html>
