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
    <title>Our Team</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Our Team</a>
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
                            <a class="nav-link" href="works.php">
                                Works
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="ourteam.php">
                                Our Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="testimonials.php">
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
                    <h1 class="h2">Our Team</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
                        </div>
                    </div>
                </div>
                <h2 id="h2-title">Consultar Team</h2>
                <div class="table-responsive view" id="show_data">
                    <table class="table table-striped table-sm" id="list-usuarios">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Puesto</th>
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
                                    <label for="correo">Correo Electrónico</label>
                                    <input type="email" id="inputCorreo" name="correo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="inputPassword" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="puesto">Puesto</label>
                                    <input type="puesto" id="inputPuesto" name="puesto" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" id="inputDescripcion" name="descripcion" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="fb-link">Facebook Link</label>
                                    <input type="text" id="inputFb" name="fb-link" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="tw-link">Twitter Link</label>
                                    <input type="text" id="inputTw" name="tw-link" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="lk-link">Linkedin Link</label>
                                    <input type="text" id="inputLk" name="lk-link" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="img">Foto:</label>
                                    <input type="file" name="foto" id="foto">
                                    <input type="hidden" name="ruta" id="ruta" readonly="readonly">
                                </div>
                                <div id="preview"></div>
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
                // $(this).addClass("d-none");
                $(this).slideUp('fast');
                let id = $(this).attr("id");
                if (vista == id) {
                    $(this).slideDown(300);
                    // $(this).removeClass("d-none");
                }
            });
        }
        //FUNCION PARA CONSULTAR A LA BD
        function consultar() {
            let obj = {
                "accion": "consultar_team"
            };
            $.post("includes/_funciones.php", obj, function (respuesta) {
                let template = ``;
                $.each(respuesta, function (i, e) {
                    template +=
                        `
          <tr>
          <td>${e.nombre}</td>
          <td>${e.puesto}</td>
          <td><img src="${e.img_team}" class="img-thumbnail" width="100" height="100"/></td>
          <td><a href="#" data-id="${e.id_team}" class = "editar_integrantes" >Editar</a>
          <a href="#" data-id="${e.id_team}" class = "eliminar_integrantes">Eliminar</a>
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
            $("#h2-title").text("Insertar Integrante");
            $("#guardar_datos").text("Guardar").data("editar", 0);
            $("#preview").html("");
            $('#ruta').attr('value', '');
            $("#form_data")[0].reset();
        });
        //FUNCION PARA INSERTAR DATOS A LA BD
        $("#guardar_datos").click(function () {
            let nombre = $("#inputNombre").val();
            let correo = $("#inputCorreo").val();
            let password = $("#inputPassword").val();
            let puesto = $("#inputPuesto").val();
            let descripcion = $("#inputDescripcion").val();
            let fb = $("#inputFb").val();
            let tw = $("#inputTw").val();
            let lk = $("#inputLk").val();
            let img_team = $("#ruta").val();
            let obj = {
                "accion": "insertar_integrantes",
                "nombre": nombre,
                "correo": correo,
                "password": password,
                "puesto": puesto,
                "descripcion": descripcion,
                "fb": fb,
                "tw": tw,
                "lk": lk,
                "img_team": img_team
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
                obj["accion"] = "editar_integrantes";
                obj["id"] = $(this).data('id');
            }
            $.post("includes/_funciones.php", obj, function (v) {
                if (v == 0) {
                    $("#error").html("Campos vacios").fadeIn();
                }
                if (v == 1) {
                    alert("Integrante Insertado");
                    location.reload();
                }
                if (v == 2) {
                    $("#error").html("Favor de ingresar tu nombre").fadeIn();
                }
                if (v == 3) {
                    $("#error").html("Favor de ingresar un correo electronico").fadeIn();
                }
                if (v == 4) {
                    $("#error").html("Favor de ingresar un correo electronico valido").fadeIn();
                }
                if (v == 5) {
                    $("#error").html("Favor de ingresar una contraseña").fadeIn();
                }
                if (v == 6) {
                    $("#error").html("Favor de ingresar su puesto").fadeIn();
                }
                if (v == 7) {
                    $("#error").html("Favor de añadir una descripción").fadeIn();
                }
                if (v == 8) {
                    $("#error").html("Favor de añadir una foto").fadeIn();
                }
                if (v == 9) {
                    $("#error").html("Favor de añadir link a Facebook").fadeIn();
                }
                if (v == 10) {
                    $("#error").html("Favor de añadir link a Twitter").fadeIn();
                }
                if (v == 11) {
                    $("#error").html("Favor de añadir link a Linkedin").fadeIn();
                }
                if (v == 12) {
                    alert("Integrante editado");
                    location.reload();
                }
                if (v == 13) {
                    alert("Se produjo un error, intente nuevamente");
                    location.reload();
                }
            });
        });
        //FUNCION PARA ELIMINAR 1 REGISTRO EN LA BD
        $("#main").on("click", ".eliminar_integrantes", function (e) {
            e.preventDefault();
            let confirmacion = confirm('¿Desea eliminar este integrante?');
            if (confirmacion) {
                let id = $(this).data('id'),
                    obj = {
                        "accion": "eliminar_integrantes",
                        "id": id
                    };
                $.post("includes/_funciones.php", obj, function (respuesta) {
                    alert(respuesta);
                    consultar();
                });
            } else {
                alert('El integrante no se ha eliminado');
            }
        });
        //FUNCION PARA CONSULTAR REGISTRO A EDITAR
        $("#list-usuarios").on("click", ".editar_integrantes", function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
                obj = {
                    "accion": "consultar_registro_integrantes",
                    "id": id
                };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#h2-title").text("Editar Integrante");
            $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);
            $.post("includes/_funciones.php", obj, function (r) {
                $("#inputNombre").val(r.nombre);
                $("#inputCorreo").val(r.correo);
                $("#inputPassword").val(r.password);
                $("#inputPuesto").val(r.puesto);
                $("#inputDescripcion").val(r.descripcion);
                $("#inputFb").val(r.facebook_link);
                $("#inputTw").val(r.twitter_link);
                $("#inputLk").val(r.linkedin_link);
                let template =
                    `
                    <img src="${r.img_team}" class="img-thumbnail" width="200" height="200"/>
                    `;
                $("#ruta").val(r.img_team);
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
            $("#h2-title").text("Consultar Team");
            $("#preview").html("");
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