<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">Menú</li>
        <?php if ($data_side): ?>
            <?php foreach ($data_side as $icono => $nombre): 
                $is_inventario = ($nombre === 'gestion inventario');
                $is_submenu_active = $is_inventario && in_array(strtolower($sucursales), array_map('strtolower', $inventario));
                $active = (!$is_inventario && strtolower($sucursales) === strtolower($nombre)) || $is_submenu_active ? 'active' : '';
                $url = str_replace(" ", "_", $nombre);
            ?>
                <li class="nav-item <?= $active; ?>" title="<?= $nombre; ?>">
                    <a class="nav-link" 
                       href="<?= $is_inventario ? '#inventario' : "./{$url}?suc={$dato}"; ?>" 
                       data-bs-toggle="<?= $is_inventario ? 'collapse' : ''; ?>" 
                       aria-expanded="<?= $is_submenu_active ? 'true' : 'false'; ?>" 
                       aria-controls="ui-advanced">
                        <span class="icon-bg"><i class="mdi <?= $icono ?> menu-icon"></i></span>
                        <span class="menu-title"><?= ucfirst($nombre); ?></span>
                        <?php if ($is_inventario): ?>
                            <i class="menu-arrow"></i>
                        <?php endif; ?>
                    </a>

                    <?php if ($is_inventario): ?>
                        <div class="collapse <?= $is_submenu_active ? 'show' : ''; ?>" id="inventario">
                            <ul class="nav flex-column sub-menu">
                                <?php foreach ($inventario as $inv): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= strtolower($sucursales) === strtolower($inv) ? 'active' : ''; ?>" href="./<?= $inv ?>?suc=<?= $dato; ?>">
                                            <?= ucfirst($inv); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</nav>
