<?php
	session_start();
	error_reporting(0);
	$varsesion = $_SESSION['usuario'];

	if (isset($varsesion)){
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Testimonials</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/estilos.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/unid-ico.ico">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="testimonials.php">Testimonials</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="includes/log_out.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">
                                Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="features.php">
                                Features
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="works.php">
                                Works
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ourteam.php">
                                Our Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="testimonials.php">
                                Testimonials
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="download.php">
                                Download
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="footer.php">
                                Footer
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Testimonials</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
                        </div>
                    </div>
                </div>
                <h2 id="h2-title">Consultar Testimonials</h2>
                <div class="table-responsive view" id="show_data">
                    <table class="table table-striped table-sm" id="list-usuarios">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th>Mensaje</th>
                                <th>Foto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="insert_data" class="view">
                    <form action="#" id="form_data" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="inputNombre" name="nombre" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="puesto">Puesto</label>
                                    <input type="puesto" id="inputPuesto" name="puesto" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="descripcion">Mensaje</label>
                                    <input type="text" id="inputMensaje" name="descripcion" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="img">Foto:</label>
                                    <input type="file" name="foto" id="foto">
                                    <input type="hidden" name="ruta" id="ruta" readonly="readonly">
                                </div>
                                <div id="preview"></div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-success" id="guardar_datos">Guardar</button>
                    </div>
                </div>
                <div class="mensaje">
                    <span class="alert alert-danger" id="error" style='display:none;'></span>
                    <span class="alert alert-success" id="success" style='display:none;'></span>
                </div>
                </form>
        </div>
        </main>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        //FUNCION PARA CAMBIAR VISTA
        function change_view(vista = 'show_data') {
            $("#main").find(".view").each(function () {
                $(this).slideUp('fast');
                let id = $(this).attr("id");
                if (vista == id) {
                    $(this).slideDown(300);
                }
            });
        }
        //FUNCION PARA CONSULTAR A LA BD
        function consultar() {
            let obj = {
                "accion": "consultar_tes"
            };
            $.post("includes/_funciones.php", obj, function (respuesta) {
                let template = ``;
                $.each(respuesta, function (i, e) {
                    template +=
                        `
          <tr>
          <td>${e.nombre_tes}</td>
          <td>${e.puesto_tes}</td>
          <td>${e.mensaje_tes}</td>
          <td><img src="${e.foto_tes}" class="img-thumbnail" width="100" height="100"/></td>
          <td>
          <a href="#" data-id="${e.id_tes}" class = "editar_testimonials" >Editar</a>
          <a href="#" data-id="${e.id_tes}" class = "eliminar_testimonials">Eliminar</a>
          </td>
          </tr>
          `;
                });
                $("#list-usuarios tbody").html(template);
            }, "JSON");
        }
        //FUNCION PARA CAMBIAR VISTA -> FORMULARIO
        $("#nuevo_registro").click(function () {
            change_view('insert_data');
            $("#h2-title").text("Insertar Testimonio");
            $("#guardar_datos").text("Guardar").data("editar", 0);
            $("#preview").html("");
            $('#ruta').attr('value', '');
            $("#form_data")[0].reset();
        });
        //FUNCION PARA INSERTAR DATOS A LA BD
        $("#guardar_datos").click(function () {
            let nombre = $("#inputNombre").val();
            let puesto = $("#inputPuesto").val();
            let mensaje = $("#inputMensaje").val();
            let foto_tes = $("#ruta").val();
            let obj = {
                "accion": "insertar_testimonials",
                "nombre": nombre,
                "puesto": puesto,
                "mensaje": mensaje,
                "foto_tes": foto_tes
            }
            $("#form_data").find("input").each(function () {
                $(this).removeClass("has-error");
                if ($(this).val() != "") {
                    obj[$(this).prop("name")] = $(this).val();
                } else {
                    $(this).addClass("has-error");
                    return false;
                }
            });
            if ($(this).data("editar") == 1) {
                obj["accion"] = "editar_testimonials";
                obj["id"] = $(this).data('id');
            }
            $.post("includes/_funciones.php", obj, function (v) {
                if (v == 0) {
                    $("#error").html("Campos vacios").fadeIn();
                }
                if (v == 1) {
                    alert("Testimonio Insertado");
                    location.reload();
                }
                if (v == 2) {
                    $("#error").html("Favor de ingresar tu nombre").fadeIn();
                }
                if (v == 3) {
                    $("#error").html("Favor de ingresar su puesto").fadeIn();
                }
                if (v == 4) {
                    $("#error").html("Favor de añadir un mensaje").fadeIn();
                }
                if (v == 7) {
                    $("#error").html("Favor de añadir una imagen").fadeIn();
                }
                if (v == 5) {
                    alert("Testimonio editado");
                    location.reload();
                }
                if (v == 6) {
                    alert("Se produjo un error, intente nuevamente");
                    change_view();
                    consultar();
                }
            });
        });
        //FUNCION PARA ELIMINAR 1 REGISTRO EN LA BD
        $("#main").on("click", ".eliminar_testimonials", function (e) {
            e.preventDefault();
            let confirmacion = confirm('¿Desea eliminar este testimonio?');
            if (confirmacion) {
                let id = $(this).data('id'),
                    obj = {
                        "accion": "eliminar_testimonials",
                        "id": id
                    };
                $.post("includes/_funciones.php", obj, function (respuesta) {
                    alert(respuesta);
                    consultar();
                });
            } else {
                alert('El testimonio no se ha eliminado');
            }
        });
        //FUNCION PARA CONSULTAR REGISTRO A EDITAR
        $("#list-usuarios").on("click", ".editar_testimonials", function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
                obj = {
                    "accion": "consultar_registro_testimonials",
                    "id": id
                };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#h2-title").text("Editar Testimonio");
            $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);
            $.post("includes/_funciones.php", obj, function (r) {
                $("#inputNombre").val(r.nombre_tes);
                $("#inputPuesto").val(r.puesto_tes);
                $("#inputMensaje").val(r.mensaje_tes);
                let template =
                    `
                    <img src="${r.foto_tes}" class="img-thumbnail" width="200" height="200"/>
                    `;
                $("#ruta").val(r.foto_tes);
                $("#preview").html(template);
            }, "JSON");
        });
        //CARGAR FUNCIONES CUANDO EL DOCUMENTO ESTE LISTO
        $(document).ready(function () {
            consultar();
            change_view();
        });
        //FUNCION PARA GUARDAR IMAGENES
        $("#foto").on("change", function (e) {
            let formDatos = new FormData($("#form_data")[0]);
            formDatos.append("accion", "carga_foto");
            $.ajax({
                url: "includes/_funciones.php",
                type: "POST",
                data: formDatos,
                contentType: false,
                processData: false,
                success: function (datos) {
                    let respuesta = JSON.parse(datos);
                    if (respuesta.status == 0) {
                        alert("No se cargó la foto");
                    }
                    let template =
                        `
          <img src="${respuesta.archivo}" class="img-thumbnail" width="200" height="200"/>
          `;
                    $("#ruta").val(respuesta.archivo);
                    $("#preview").html(template);
                }
            });
        });
        //BOTON CANCELAR
        $("#main").find(".cancelar").click(function () {
            change_view();
            $("#form_data")[0].reset();
            $("#form_data").find("input").each(function () {
                $(this).removeClass("has-error");
            });
            $("#error").hide();
            $("#success").hide();
            $("#h2-title").text("Consultar Testimonials");
            $("#preview").html("");
            $("#ruta").html("");
            if ($("#guardar_datos").data("editar") == 1) {
                $("#guardar_datos").text("Guardar").data("editar", 0);
                consultar();
            }
        });
    </script>
</body>

</html>
<?php
	}else{
		header("Location:index.php");
	}
?>