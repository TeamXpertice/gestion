<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $title ?? 'Sistema' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE | Dashboard v3">
    <meta name="author" content="ColorlibHQ">
    <link rel="icon" href="/gestion/public/img/favicon.ico" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">

    <link rel="stylesheet" href="/gestion/public/resources/dist/css/adminlte.css">
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/datatables1.10.21/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/gestion/public/css/datatablesbuttons1.6.2/buttons.dataTables.min.css">

    <?php if (!empty($additionalCss)) : ?>
        <?php foreach ($additionalCss as $cssFile) : ?>
            <?php echo "<!-- CSS File: $cssFile -->"; ?>
            <link rel="stylesheet" href="<?= $cssFile ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="/gestion/app/controller/DashboardController.php?action=showDashboard" class="nav-link">Inicio</a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"><i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <span class="d-none d-md-inline"><?= htmlspecialchars($_SESSION['nombres'] ?? 'Invitado') ?></span> </a>

                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand"> <a href="/gestion/app/controller/DashboardController.php?action=showDashboard" class="brand-link"> <img src="/gestion/public/resources/img/logo.jpeg" alt="BaseCowork" class="brand-image opacity-75 "> </a> </div>
            <div class="sidebar-wrapper">


                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false" color="#8b783d">
                        <li class="nav-item">
                            <a href="/gestion/app/controller/DashboardController.php?action=showDashboard" class="nav-link">
                                <i class="nav-icon bi bi-house-door"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box"></i>
                                <p>
                                    Productos Generales
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/ArsenalVentaController.php?action=showVentaConsumible" class="nav-link">
                                        <i class="nav-icon bi bi-cart-plus"></i>
                                        <p>Vender Productos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/ArsenalController.php?action=showVentasRegistradas" class="nav-link">
                                        <i class="nav-icon bi bi-journal-text"></i>
                                        <p>Registro de Venta</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/ArsenalController.php?action=showConsumible" class="nav-link">
                                        <i class="nav-icon bi bi-eye"></i>
                                        <p>Ver Productos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-building"></i>
                                <p>
                                    Bienes Generales
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/BienController.php?action=listarBienes" class="nav-link">
                                        <i class="nav-icon bi bi-pencil-square"></i>
                                        <p>Registro de Bienes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-bag"></i>
                                <p>
                                    Compras Generales
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/ComprasController.php?action=showCompras" class="nav-link">
                                        <i class="nav-icon bi bi-cart-check"></i>
                                        <p>Realizar Nueva Compra</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras" class="nav-link">
                                        <i class="nav-icon bi bi-file-earmark-text"></i>
                                        <p>Registro de Compras</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>
                                    Perdidas
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/NoEncontradoController.php?action=showNoEncontradoController" class="nav-link">
                                        <i class="nav-icon bi bi-box"></i>
                                        <p>Registrar Perdidas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/NoEncontradoController.php?action=showNoEncontradoController" class="nav-link">
                                        <i class="nav-icon bi bi-box-seam"></i> <!-- Cambié el ícono aquí -->
                                        <p>Ver Perdidas</p>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>
                                    Configuraciones
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/CategoriaController.php?action=showCategorias" class="nav-link">
                                        <i class="nav-icon bi bi-box"></i>
                                        <p>Categorías de Productos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/CategoriaBienesController.php?action=showCategorias" class="nav-link">
                                        <i class="nav-icon bi bi-box-seam"></i> <!-- Cambié el ícono aquí -->
                                        <p>Categorías de Bienes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/gestion/app/controller/AdministradorController.php?action=showAdministradores" class="nav-link">
                                        <i class="nav-icon bi bi-person-circle"></i> <!-- Cambié el ícono aquí -->
                                        <p>Administradores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                       

                        <li class="nav-header">-------------------------------------------</li>
                        <li class="nav-item">
                            <a href="/gestion/app/controller/logoutController.php" id="cerrarSesion" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Cerrar Sesión</p>
                            </a>
                        </li>
                    </ul>
                </nav>


<!-- /gestion/app/controller/404.php?action=showNoEncontradoController -->

            </div>
        </aside>



        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <?php include $viewPath; ?>
                    </div>
                </div>
            </div>
        </main>

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>


    <!-- Scripts globales -->
    <script src="/gestion/public/js/code.jquery3.6.0/jquery-3.6.0.min.js"></script>
    <script src="/gestion/public/js/cloudflare3.1.3/jszip.min.js"></script>

    <script src="/gestion/public/js/popper1.16.0/popper.min.js"></script>
    <script src="/gestion/public/js/stackpath.bootstrap4.5.2/bootstrap.min.js"></script>
    <!-- Scripts data table -->
    <script src="/gestion/public/js/datatables1.10.21/jquery.dataTables.min.js"></script>
    <script src="/gestion/public/js/datatablesbuttons1.6.2/dataTables.buttons.min.js"></script>
    <script src="/gestion/public/js/datatablesbuttonsflash1.6.2/buttons.flash.min.js"></script>
    <script src="/gestion/public/js/datatablesbuttonshtml51.6.2/buttons.html5.min.js"></script>
    <script src="/gestion/public/js/datatablesbuttonsprint1.6.2/buttons.print.min.js"></script>
    <!-- Scripts sweetalert-->
    <script src="/gestion/public/js/sweetalert2@10/sweetalert2@10.js"></script>

    <script src="/gestion/public/resources/dist/js/adminlte.js"></script>

    <!-- Scripts adicionales -->
    <?php if (!empty($additionalJs)) : ?>
        <?php foreach ($additionalJs as $jsFile) : ?>
            <script src="<?= $jsFile ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>



</body>

</html>