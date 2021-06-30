<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

$file = $_GET['file'] ?? '.';
$path = "./scripts/manage_dir.php?file=" . $file;
?>

<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            + Add
        </button>
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
                    <!-- <form action="<?= $path ?>" method="post"> -->
                    <form action="" method="post" id="mkdir">
                        <div class="modal-body">
                            <input type="text" id="defaultForm-name" name="directory-name" placeholder="Insert directory name" class="form-control validate">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">New folder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><br><br>
        <!-- Modal -->

        <!-- Upload Async Test -->

        <div id="container">

            <input type="file" name="fileToUpload form-control"></input><br>
            <input type="text" placeholder="File name" id="filename" class="form-control"><br>
            <button class="btn btn-success" onclick="uploadfile()">UPLOAD</button>

        </div>


        <!-- <form enctype="multipart/form-data">
            <input name="file" type="file" /><br><br>
            <input type="button" value="Upload" /><br><br>
        </form>
        <progress></progress><br><br> -->

        <!-- END -->



        <h5 class="my-3">File Explorer</h5>
        <div class="fm-menu">
            <div class="list-group list-group-flush"> <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-folder me-2"></i><span>All Files</span></a>
                <a href="./" class="list-group-item py-1"><i class="bx bx-devices me-2"></i><span>Root</span></a>
                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-analyse me-2"></i><span>Documents</span></a>
                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Images</span></a>
                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Audio</span></a>
                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Video</span></a>
                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-trash-alt me-2"></i><span>Deleted Files</span></a>
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
                console.log("Error doing ", data.action);
            }
        }, 'json');
    });

    $('#exampleModalCenter').on('shown.bs.modal', function() {
        $('#defaultForm-name').trigger('focus')
    })


    //Upload Async

    function uploadfile() {
        var filename = $('#filename').val();
        var file_data = $('fileToUpload').prop('files')[0];
        var form_data = new FormData();
        form_data.append("file", file_data);
        form_data.append("filename", filename);

        //Ajax send file to upload

        $.ajax({
            type: "POST",
            url: "load.php", //Server api to recieve the file
            data: form_data,
            dataType: "script",
            cache: false,
            contentType: false,
            processData: false,


            success: function(dat2) {
                if (dat2 == 1) alert("YASSSS Success!!!!");
                else alert("unable to upload");

            }
        });

    }; //END





    // $(':file').on('change', function() {
    //     var file = this.files[0];

    //     if (file.size > 1024) {
    //         alert('max upload size is 1k');
    //     }
    //     console.log(file.size);

    //     // Also see .name, .type
    // });

    // $(':button').on('click', function() {
    //     $.ajax({
    //         // Your server script to process the upload
    //         url: 'aside.php',
    //         type: 'POST',

    //         // Form data
    //         data: new FormData($('form')[0]),

    //         // Tell jQuery not to process data or worry about content-type
    //         // You *must* include these options!
    //         cache: false,
    //         contentType: false,
    //         processData: false,

    //         // Custom XMLHttpRequest
    //         xhr: function() {
    //             var myXhr = $.ajaxSettings.xhr();
    //             if (myXhr.upload) {
    //                 // For handling the progress of the upload
    //                 myXhr.upload.addEventListener('progress', function(e) {
    //                     if (e.lengthComputable) {
    //                         $('progress').attr({
    //                             value: e.loaded,
    //                             max: e.total,
    //                         });
    //                     }
    //                 }, false);
    //             }
    //             return myXhr;
    //         }
    //     });
    // });
</script>