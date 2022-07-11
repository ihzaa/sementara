<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
    <title>Document</title>
</head>
<style>
    .card-top{
        height: 10px;
    }
</style>
<body>

    <div class="container ">
        <p class="text-center my-4 font-weight-bold" style="font-size: 2rem">Monitoring Suhu Server</p>
        <hr>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 my-3">
                <div class="card shadow">
                    <div class="card-top bg-primary"></div>
                    <div class="card-body">
                        <p class="font-weight-bold text-center" style="font-size: 1.5rem">Suhu</p>
                        <hr>
                        <p class="text-center suhu" style="font-size: 1.4rem">0 C</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-3">
                <div class="card shadow">
                    <div class="card-top bg-success"></div>
                    <div class="card-body">
                        <p class="font-weight-bold text-center" style="font-size: 1.5rem">Kelembapan</p>
                        <hr>
                        <p class="text-center lembab" style="font-size: 1.4rem">0%</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 my-4">
                <div class="card shadow">
                    <div class="card-top {{ $data->status->id == 4 ? 'bg-success' : 'bg-danger' }}"></div>
                    <div class="card-body">
                        <p class="font-weight-bold text-center" style="font-size: 1.5rem">Status</p>
                        <hr>
                        <p class="text-center status" style="font-size: 1.4rem"> </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-auto text-center btn-lihat" data-toggle="modal" data-target="#exampleModal">
            <p class="btn btn-primary font-weight-bold">Lihat selengkapnya</p>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Report</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Suhu</th>
                            <th scope="col">Kelembapan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Waktu</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
    </div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    async function getData() {
        let url = '{{ Route('get') }}';
         fetch(url)
            .then(res => res.json())
            .then(rs =>{
                $('.suhu').text(`${rs.data.suhu} C`);
                $('.lembab').text(`${rs.data.kelembapan} %`)
                $('.status').text(rs.data.status.status)
            } )
    }

    $('.btn-lihat').click(function(){
        let url = '{{  Route('getTable') }}'
        fetch(url)
            .then(res => res.json())
            .then(rs => {
                let mapTable = '';

                rs.data.map((result,i) =>{
                    $("table").DataTable().clear().destroy();
                    mapTable += `<tr>
                        <th scope="row">${i+1}</th>
                        <td>${result.suhu}</td>
                        <td>${result.kelembapan}</td>
                        <td>${result.status.status}</td>
                        <td>${moment(result.created_at).format('LLL')}</td>
                        </tr>`
                })

                $('table tbody').append(mapTable);
                $("table").DataTable({
                    lengthMenu: [5, 10, 20, 50],
                });
            })
    })
    
     window.Echo.channel("sensor").listen("DataCreate", (event) => {
        getData();
    });
</script>
</body>
</html>
