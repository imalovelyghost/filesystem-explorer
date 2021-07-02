<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

$file = $_GET['file'] ?? '';
$path = "./scripts/manage_dir.php?file=" . $file;
$MAX_SIZE_FORMATTED = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
$MAX_UPLOAD_SIZE = min(asBytes(ini_get('post_max_size')), asBytes(ini_get('upload_max_filesize')));
?>

<div class="card">
    <div class="card-body">
        <div class="dropdown">
            <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                + Add
            </button>
            <div class="dropdown-menu shadow-lg" data-file="<?= $entry["path"]; ?>" aria-labelledby="dropdownMenuButton">
                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter">
                    <i class="bi bi-folder-plus"></i>
                    <span>Directory</span>
                </button>
                <button type="button" class="dropdown-item">
                    <label for="file" class="m-0">
                        <i class="bi bi-file-arrow-up"></i>
                        <span>Upload file</span>
                    </label>
                    <input type="file" name="file" id="file" class="input-file" multiple />
                </button>
                <button type="button" class="dropdown-item">
                    <i class="bi bi-folder-symlink"></i>
                    <span>Upload folder</span>
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" id="mkdir">
                        <div class="modal-body">
                            <input type="text" id="defaultForm-name" name="directory-name" placeholder="Insert directory name" class="form-control validate">
                            <div class="invalid-feedback defaultForm-name">
                                error message
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">New folder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <h5 class="my-3">File Explorer</h5>
        <div class="fm-menu">
            <div class="list-group list-group-flush">
                <!-- <a href="javascript:;" class="list-group-item py-1"><i class="bi bi-files-alt"></i><span> All Files</span></a> -->
                <a href="./" class="list-group-item py-1 pl-1"><i class="bi bi-folder-minus"></i><span> Root</span></a>
                <a href="javascript:;" class="list-group-item py-1 pl-3"><i class="bi bi-folder"></i><span> Documents</span></a>
                <a href="javascript:;" class="list-group-item py-1 pl-3"><i class="bi bi-image-fill"></i><span> Images</span></a>
                <a href="javascript:;" class="list-group-item py-1 pl-3"><i class="bi bi-record-btn"></i><span> Audio</span></a>
                <a href="javascript:;" class="list-group-item py-1 pl-3"><i class="bi bi-camera-video"></i><span> Video</span></a>
                <a href="javascript:;" class="list-group-item py-1 pl-3"><i class="bi bi-archive"></i><span> Deleted Files</span></a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#mkdir').submit(function(e) {
        e.preventDefault();
        $dir = $(this).find('[name="directory-name"]');
        $dir.val().length && $.post("<?= $path ?>", {
            'action': 'mkdir',
            dirname: $dir.val(),
        }, function(data) {
            if (data.status) {
                window.location.reload();
            } else {
                $('#defaultForm-name').addClass('is-invalid');
                $('.defaultForm-name').text(data.msg);
                console.log("Error doing ", data.action);
            }
        }, 'json');
    });

    $('#exampleModalCenter').on('shown.bs.modal', function() {
        $('#defaultForm-name').trigger('focus')
    })

    $('input[type=file]').change(function(e) {
        e.preventDefault();
        $.each(this.files, function(k, file) {
            uploadFile(file);
        });
    })

    function uploadFile(file) {
        const MAX_UPLOAD_SIZE = <?= $MAX_UPLOAD_SIZE ?>,
            MAX_SIZE_FORMATTED = "<?= $MAX_SIZE_FORMATTED ?>",
            dir = "<?= $file ?>";
        let formData = new FormData();
        formData.append("do", "upload-file");
        formData.append("file", file);
        formData.append("dir", dir);
        if (file.size > MAX_UPLOAD_SIZE) {
            $('#danger-alert').addClass('show');
            $('#danger-alert').
            text('Size exceeds max_upload_size ' + MAX_SIZE_FORMATTED);
            window.setTimeout(function() {
                $('#danger-alert').removeClass('show');
            }, 5000);
            return;
        }
        $.ajax({
                xhr: xhrProgressBar,
                url: "./scripts/upload_files.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res) {
                console.log(res);
            });

        function xhrProgressBar() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('loadstart', function(e) {
                $('#progress-alert').addClass('show');
            })
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percent = Math.round((e.loaded / e.total * 100));
                    $('.progress-bar').css('width', percent + '%');
                }
            });
            xhr.upload.addEventListener('load', function(e) {
                $('#progress-alert').removeClass('show');
                $('#success-alert').addClass('show');
                $('#success-alert').
                text('File ' + file.name + ' uploaded successfully');
                window.setTimeout(function() {
                    window.location.reload();
                }, 2000);
            });
            return xhr;
        }
    }
</script>