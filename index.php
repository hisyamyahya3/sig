<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS SIG</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script src="assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/atlantis.min.css">
	<link href="assets/styles.css" rel="stylesheet" />
	<link href="assets/prism.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body data-background-color="dark">
    <div class="wrapper">
        <div class="main-header">
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">

            </nav>
        </div>
        <div class="main-panel">
            <div class="content">
                <div class="page-inner mt--3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body" id="kategori">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="petaku" class="map map-home" style="height: 300px; width: 900px; margin-top: 5px"></div>
                        </div>
                        <div class="container">
                            <div class="row" id="hisyamdewacoding"></div>
                            <!-- <div class="card-success">
                                <div class="card-header">
                                    <div class="card-title">Data</div>
                                </div>
                                <div class="card-body">
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-warning" onclick="">detail</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <button class="btn btn-primary">
                                            Satelite
                                        </button>
                                        <button class="btn btn-secondary">
                                            Hybrid
                                        </button>
                                        <button class="btn btn-warning">
                                            Street
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <script>
        let hasilpeta = L.map('petaku').setView([-7.520295197871834, 112.2323087686914], 19);
        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']}).addTo(hasilpeta);
        // L.tileLayer(`http://{s}.google.com/vt/lyrs=` + ${tombol} + `&x={x}&y={y}&z={z}`,{maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']}).addTo(hasilpeta);
        // L.tileLayer(`http://{s}.google.com/vt/lyrs=${tombol}&x={x}&y={y}&z={z}`,{maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']}).addTo(hasilpeta);

        $.ajax({
			type: "GET",
			url: "http://localhost/api_sig/api_kategori.php",
			success: function(result) {
                let dt = "";
                let res = JSON.parse(result)
                $.each(res, function(i, col) {
                    let nama = col.nama;
                    dt += `<li onclick='showCategory(${col.id})'>${nama}</li>`;
                });

                $("#kategori").html(`<ul>${dt}</ul>`)
			}
		})

        function showCategory(id)
        {
            $.ajax({
                type: "POST",
                url: "http://localhost/api_sig/api_search_lokasi.php",
                // dataType: 'json',
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'id': id
                },
                success: function(result) {
                    let dt = "";
                    let res = JSON.parse(result)
                    console.log(res)
                    $.each(res, function(i, col) {
                        let nama = col.nama;
                        let no = col.id;
                        let lintang = col.lintang;
                        let bujur = col.bujur;
                        dt += `
                                <div class="card-primary m-2">
                                    <div class="card-header">
                                        <h5>${no}</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>${nama}</h5>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-warning" onclick="">detail</button>
                                    </div>
                                </div>
                            `
                            L.marker([lintang, bujur]).addTo(hasilpeta);
                    });

                    $("#hisyamdewacoding").html(dt)
                }
            });

            function kelokasi(el){
                let lintang = $(el).data("lintang");
                let bujur = $(el).data("bujur");
                hasilpeta.flyTo([lintang, bujur], 18);
            }
        }
        
        // $.getJSON("http://localhost/api_sig/api_kategori.php", function(result){
            //     if(result.length > 0){
            //         var dt = "";
            //         $.each(result, function(i, kolom){
            //             let nama = kolom.nama;
            //             dt += `<li>${nama}</li>`;
            //         });
            //         $("#kategori").html(`<ul>${dt}</ul>`)
            //     }
        // });
    </script>
</body>
</html>