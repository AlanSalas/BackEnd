<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Usuarios</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="index.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="usuarios.php">
                                Usuarios <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ourteam.php">
                                Our Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                Integrations
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Usuarios</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
                        </div>
                    </div>
                </div>
                <h2 id="h2-title">Consultar Usuarios</h2>
                <div class="table-responsive view" id="show_data">
                    <table class="table table-striped table-sm" id="list-usuarios">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="insert_data" class="view">
                    <form action="#" id="form_data">
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
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="tel" id="inputTelefono" name="telefono" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="inputPassword" name="password" class="form-control">
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
                "accion": "consultar_usuarios"
            };
            $.post("includes/_funciones.php", obj, function (respuesta) {
                let template = ``;
                $.each(respuesta, function (i, e) {
                    template +=
                        `
          <tr>
          <td>${e.nombre_usr}</td>
          <td>${e.telefono_usr}</td>
          <td>
          <a href="#" data-id="${e.id_usr}" class="editar_usuario">Editar</a>
          <a href="#" data-id="${e.id_usr}" class="eliminar_usuario">Eliminar</a>
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
            $("#h2-title").text("Insertar Usuario");
        });
        //FUNCION PARA INSERTAR DATOS A LA BD
        $("#guardar_datos").click(function () {
            let nombre_usr = $("#inputNombre").val();
            let correo_usr = $("#inputCorreo").val();
            let telefono_usr = $("#inputTelefono").val();
            let password_usr = $("#inputPassword").val();
            let obj = {
                "accion": "insertar_usuarios",
                "nombre_usr": nombre_usr,
                "correo_usr": correo_usr,
                "telefono_usr": telefono_usr,
                "password_usr": password_usr
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
                obj["accion"] = "editar_usuario";
                obj["id"] = $(this).data('id');
            }
            $.post("includes/_funciones.php", obj, function (v) {
                if (v == 0) {
                    $("#error").html("Campos vacios").fadeIn();
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
                    $("#error").html("Favor de ingresar un telefono").fadeIn();
                }
                if (v == 6) {
                    $("#error").html("Favor de ingresar un telefono numerico").fadeIn();
                }
                if (v == 7) {
                    $("#error").html("Favor de ingresar una contraseña").fadeIn();
                }
                if (v == 8) {
                    alert("Usuario editado");
                    location.reload();
                }
                if (v == 9) {
                    alert("Se produjo un error, intente nuevamente");
                    location.reload();
                }
                if (v == 1) {
                    alert("Usuario insertado");
                    location.reload();
                }
            });
        });
        //FUNCION PARA ELIMINAR 1 REGISTRO EN LA BD
        $("#main").on("click", ".eliminar_usuario", function (e) {
            e.preventDefault();
            let confirmacion = confirm('¿Desea eliminar este usuario?');
            if (confirmacion) {
                let id = $(this).data('id'),
                    obj = {
                        "accion": "eliminar_usuario",
                        "id": id
                    };
                $.post("includes/_funciones.php", obj, function (respuesta) {
                    alert(respuesta);
                    consultar();
                });
            } else {
                alert('El registro no se ha eliminado');
            }
        });
        //FUNCION PARA CONSULTAR REGISTRO A EDITAR
        $("#list-usuarios").on("click", ".editar_usuario", function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
            obj = {
                "accion": "consultar_registro",
                "id": id
            };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#h2-title").text("Editar Usuario");
            $("#guardar_datos").text("Editar").data("editar", 1).data("id",id);
            $.post("includes/_funciones.php", obj, function (r) {
                $("#inputNombre").val(r.nombre_usr);
                $("#inputCorreo").val(r.correo_usr);
                $("#inputTelefono").val(r.telefono_usr);
                $("#inputPassword").val(r.password_usr);
            }, "JSON");
        });
        //CARGAR FUNCIONES CUANDO EL DOCUMENTO ESTE LISTO
        $(document).ready(function () {
            consultar();
            change_view();
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
            $("#h2-title").text("Consultar Usuarios");
        });
    </script>
</body>

</html>