<div precarga class="precarga text-center d-flex justify-content-center">
    <div class="p-5 position-fixed">
        <div class="circle-loader mb-4"></div>
        <span class="h1 display-3"><?= $dataEmpr->sucursales && isset($sucursales[$dato]->nombre) ? $sucursales[$dato]->nombre : $dataEmpr->nombre; ?></span>
    </div>
</div>
