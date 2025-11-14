<?php
// TODO Refereer check

$getParameters = $_GET;
$language = (!empty($_GET['language']) && strtoupper(trim($_GET['language'])) === 'DEU') ? 'de' : 'en';

/**
 * Übersetzungen
 */
$translates = array(
        'de' => array(
                'title_1' => 'VPI-Tools',
                'btn_0' => 'Jetzt starten',
                'btn_1' => '',
                'btn_2' => '',
                'name_1' => 'Dokumentenfreigabe für Interessenten',
                'name_2' => 'KI: Bildbearbeitung 2.0',
                'label_1' => 'Hier können Sie Dokumente für Kaufinteressenten im digitalen Käuferservice freischalten.',
                'label_2' => 'Hier können Sie Ihre Immobilienfotos optimieren – inklusive Innenraum, Außenwetter sowie gezielter Unschärfe.',
        ),
        'en' => [
                'title_1' => 'VPI-Tools',
                'btn_0' => 'Start Now',
                'btn_1' => '',
                'btn_2' => '',
                'name_1' => 'Document Sharing for Prospects',
                'name_2' => 'AI: Image Editor 2.0',
                'label_1' => 'Here you can release documents for prospective buyers in the digital buyer service.',
                'label_2' => 'Here you can optimize your property photos – including interior, exterior weather, and targeted blur.',
        ]
);
$i18n = $translates[$language];

$toolsBtns = array(
        'document-sharing-for-prospects' => array(
                'name' => $i18n['name_1'],
                'label' => $i18n['label_1'],
                'icon' => '<i class="fa-solid fa-file"></i>',
                'url' => 'https://home.von-poll.com/de-de/buyer-expose-files',
                'params' => ['EstateId', 'OwnerIds', 'apiClaim', 'customerName', 'customerWebId', 'groupId', 'language', 'parameterCacheId', 'timestamp', 'userId', 'userid', 'signature'],
        ),
        'ai-image-editing-2' => array(
                'name' => $i18n['name_2'],
                'label' => $i18n['label_2'],
                'icon' => '<i class="fa-solid fa-image"></i>',
                'url' => 'https://erp.von-poll.com/projects/public/ki-bildbearbeitung/index/onoffice',
                'params' => ['objektnrExtern', 'userId', 'customerWebId'],
        ),
);

// bild the tool urls with parameters
foreach ($toolsBtns as $key => $tool) {
    $url = $tool['url'];
    $params = $tool['params'];
    $query = [];
    foreach ($params as $paramKey) {
        if (isset($getParameters[$paramKey])) {
            $query[$paramKey] = $getParameters[$paramKey];
        }
    }

    if ($key === 'ai-image-editing-2') {
        $toolsBtns[$key]['url'] = $url . '/' . $query['objektnrExtern'] . '/' . $query['userId'] . '/' . $query['customerWebId'] . '/' . $language;
    } else {
        $connector = (strpos($url, '?') !== false) ? '&' : '?';
        $fullUrl = $url . ($query ? $connector . http_build_query($query) : '');
        $toolsBtns[$key]['url'] = $fullUrl;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Projects - Intranet von Poll Immobilien GmbH</title>

    <script>
        const webRootPath = "/projects/public";
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./assets/css/adminlte.min.css">
    <!-- Eigene styles -->
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" media="all" />

    <style>
        .content-wrapper>.content { padding: 0; }
        @media (min-width: 576px) {
            .content-wrapper, .main-footer, .main-header {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<style>
    html, body, body .wrapper .content-wrapper { background: unset; }
    .unselectable,
    .noselect {
        user-select: none;
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* IE/Edge */
    }
    .btn { cursor: pointer; }
    .btn-info { background-color: #4e73f4; border-color: #4e73f4; }
    .btn-info:hover { background-color: #3f5dc9; border-color: #3f5dc9; }

    .bg-info { background-color: #00305e !important; border-color: #00305e !important; }
    .bg-info:hover { background-color: #4e73f4 !important; border-color: #4e73f4 !important; }

    #btns-wrapper { box-shadow: unset; background-color:unset; }
    #btns-wrapper .card-body { text-align: left; border: 0; padding: 1.75rem 1.25rem; }
    #btns-wrapper .card-body .row { display: flex; flex-wrap: wrap; }
    #btns-wrapper .card-body .one-btn-wrapper { display: flex; }
    #btns-wrapper .card-body .one-btn-wrapper .small-box { flex: 1; }
    #btns-wrapper .card-body .one-btn-wrapper .small-box .inner { padding: 15px 120px 15px 15px; height: calc(100% - 32px); }
    #btns-wrapper .card-body .one-btn-wrapper .small-box .inner h3 {
        font-size: 1.2rem;
        white-space: normal;
        word-wrap: break-word;
        word-break: break-word;
    }
    #btns-wrapper .card-body .one-btn-wrapper .small-box .inner p { font-size: 0.8rem; color: rgba(255, 255, 255, 0.6); }
    #btns-wrapper .card-body .one-btn-wrapper .small-box .small-box-footer { border-radius: .25rem; padding: 3px 20px 5px 20px; }

    @media (max-width: 768px) {
        #btns-wrapper .card-body .one-btn-wrapper .small-box .inner { padding: 15px; }
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div id="tool-container" class="container-fluid">

            <!--
            <div style="padding: 0 20px;">
                <h3 style="border-bottom: 2px solid #00366b; padding-bottom: 13px; margin-bottom: 27px; color: #00366b"><?=$i18n['title_1']?></h3>
            </div>
            -->

            <?php
            if(false) {
                ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-info"></i> <?=$i18n['label_9']?></h5>
                    <p><?=$i18n['label_10']?><br/><a target="_self" href="https://von-poll.shop/public/smalltools/visual_staging/upload/vs2.php?user=<?=$internet_username?>&language=<?=$language?>"><i class="icon fas fa-link"></i> &nbsp;<?=str_replace(' 2.0', '', $i18n['title_1'])?></a><br/><?=$i18n['label_11']?></p>
                </div>
                <?php
            }
            ?>

            <div id="btns-wrapper" class="card card-default unselectable">
                <div class="card-body">
                    <div class="row">
                        <?php
                        if (!empty($toolsBtns)) {
                            foreach ($toolsBtns as $k => $v) {
                                ?>
                                <div class="one-btn-wrapper col-12 col-sm-6 col-md-4 col-lg-3">
                                    <!-- small card -->
                                    <div class="small-box bg-info">
                                        <a href="javascript:void(0);" onclick="openToolWindow('<?=$v['url']?>')">
                                            <div class="inner">
                                                <h3><?=$v['name']?></h3>

                                                <p><?=$v['label']?></p>
                                            </div>
                                        </a>
                                        <div class="icon">
                                            <?=$v['icon']?>
                                        </div>
                                        <a href="javascript:void(0);" onclick="openToolWindow('<?=$v['url']?>')" class="small-box-footer">
                                            <?=$i18n['btn_0']?> &nbsp; <i class="fa-solid fa-circle-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    function openToolWindow(url) {
        const features = [
            "toolbar=no",
            "menubar=no",
            "scrollbars=yes",
            "resizable=yes",
            "location=no",
            "status=no",
            "titlebar=yes",
            "width=1200",
            "height=800"
        ].join(",");

        window.open(url, "_blank", features);
    }
</script>
</div>
</body>
</html>
