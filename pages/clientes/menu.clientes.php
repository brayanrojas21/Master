<?php ( !isset( $side_bar ) ) ? header( 'Location: /' ) : ""; ?>
<div class="container-scroller">
    <?=$nav_bar; ?>
    <div class="container-fluid page-body-wrapper">
        <?= $side_bar; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
   
                <div class="text-center">
                    <h1 >Bienvenido</h1>
                    <p>navega por las funcionalidades que de brinda nuestro sistema de gestion de equipos</p>
                </div>
                
            </div>
        </div>

    </div>
</div>
