<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <div class="navbar-brand brand-logo">
            <img src="<?=$dataEmpr->logo;?>" alt="logo">
        </div>
        <a class="navbar-brand brand-logo-mini" href="../../index.html">
            <img src="<?=$dataEmpr->icono;?>" alt="logo">
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <div class="my-auto d-flex">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <?php if ( $dataEmpr->sucursales && is_array ($sucur) && !empty($sucur) ) { ?>
            <div class="btn-group">
                <span class="my-auto mdi mdi-home-map-marker text-danger h2 text-gradient-primary"></span>
                <button type="button" class="btn text-dark dropdown-toggle ps-1 btn-icon-only" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="my-auto h3"><?= $sucursales[$dato]->nombre ?? ''; ?></span>
                </button>
                <ul class="dropdown-menu">
                    <?php foreach ($sucursales as $key => $datos) {  ?>
                    <li><a class="dropdown-item" href="?suc=<?=$key;?>"><?=$datos->nombre?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="./assets/images/foto.png" alt="image">
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-0 text-black"><?=$user->nombre?></p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-end p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                    <div class="p-3 text-center bg-gradient-danger">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="./assets/images/foto.png" alt="">
                    </div>
                    <div class="p-2">
                        <p class="dropdown-item py-1 d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#Salir">
                            <span>salir</span>
                            <i class="mdi mdi-logout ms-1"></i>
                        </p>
                    </div>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
