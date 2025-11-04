<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?="{$titulo} | {$dataEmpr->nombre}"; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/css/dropzone.min.css">
    <link rel="stylesheet" href="/assets/vendors/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendors/datatables/responsive.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/smart_wizard_all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/select2-bootstrap.min.css?v1" />
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css?v6">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?=$dataEmpr->icono; ?>" />
    <script>var sucursal = "<?=isset($mi_sucur)  && $dataEmpr->sucursales ? $mi_sucur[$dato] : 1;?>"</script>
</head>

<body class="sidebar-fixed">
