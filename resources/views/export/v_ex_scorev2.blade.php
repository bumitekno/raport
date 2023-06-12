<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Template Import Data  Mata Pelajaran</title>
  </head>
  <body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">code</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">nis</td>
                <td style="text-align: center; font-size:10px">kkm</td>
                <td style="text-align: center; font-size:10px">final_assegment</td>
                <td style="text-align: center; font-size:10px">predicate_assegment</td>
                <td style="text-align: center; font-size:10px">final_skill</td>
                <td style="text-align: center; font-size:10px">predicate_skill</td>
            </thead>
        </table>
        <tbody>
        </tbody>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Kode Siswa</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Nama Siswa</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">NIS</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">KKM</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Nilai Pengetahuan</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Predikat Pengetahuan</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Nilai Ketrampilan</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Predikat Ketrampilan</td>
            </thead>
        </table>
        <tbody>
          @foreach ($result as $data)
              <tr>
                  <td style="font-size:10px; text-align: center;">{{ $data['code'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['name'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['nis'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['kkm'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['final_assegment'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['predicate_assegment'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['final_skill'] }}</td>
                  <td style="font-size:10px; text-align: center;">{{ $data['predicate_skill'] }}</td>
              </tr>
          @endforeach
      </tbody>
    </div>
  </body>
</html>
