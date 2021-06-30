<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

$file = $_GET["file"] ?? "";
$arrFiles = getFilesInfo($file);
?>

<div class="row">
    <div class="col-sm">
        <?php
        if (is_array($arrFiles)) {
            foreach ($arrFiles as $entry) {
        ?>
                <div class="row">
                    <div class="col-sm">
                        <?php
                        echo fileIcon($entry);
                        echo getAnchor($entry);
                        ?>
                    </div>
                    <div class="col-sm">
                        <?php formatDate($entry["ctime"]); ?>
                    </div>
                    <div class="col-sm">
                        <?php formatDate($entry["mtime"]); ?>
                    </div>
                    <div class="col-sm">
                        <?= FormatSize($entry); ?>
                    </div>
                    <div class="col-sm-2 d-flex justify-content-end">
                        <div class="dropdown">
                            <button class="btn " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <div class="dropdown-menu shadow-lg" data-file="<?= $entry["path"]; ?>" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item delete" href="#">Delete</a>
                                <a class="dropdown-item rename" href="#">Rename</a>
                                <a class="dropdown-item" href="#">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12 mt-3 p-0">
                <?= $arrFiles; ?>
            </div>
        <?php
        }
        include_once('./modules/modal.php');
        ?>
    </div>
</div>

<script>
    $('.delete').click(function(e) {
        e.preventDefault();
        $.post("./scripts/manage_dir.php", {
            'action': 'delete',
            file: $(this).parent().attr('data-file'),
        }, function(data) {
            console.log(data);
            if (data.status) {
                window.location.reload();
            } else {
                console.log("Error doing ", data.action);
            }
        }, 'json');
    });

    $('.rename').click(function(e) {
        e.preventDefault();
        $('#renameModalCenter').modal('toggle');
        let file = $(this).parent().attr('data-file');
        $('#renameForm-file').val(file);
    });

    $('#formRename').submit(function(e) {
        e.preventDefault();
        $delFile = $(this).find('[name="directory-file"]');
        $dir = $(this).find('[name="directory-name"]');
        $dir.val().length && $.post("./scripts/manage_dir.php", {
            'action': 'rename',
            file: $delFile.val(),
            dirname: $dir.val(),
        }, function(data) {
            if (data.status) {
                window.location.reload();
            } else {
                $('#renameForm-name').addClass('is-invalid');
                $('.renameForm-name').text(data.msg);
                console.log("Error doing ", data.action);
            }
        }, 'json');
    });

    $('#renameModalCenter').on('shown.bs.modal', function() {
        $('#renameForm-name').trigger('focus');
    });

    $('a[data-type="iframe"], [data-type="image"]').each(function() {
        $(this).magnificPopup({
            type: $(this).attr('data-type'),
            src: $(this).attr('href'),
        });
    });
</script>