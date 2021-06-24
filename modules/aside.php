<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

$file = $_GET['file'] ?? '';
// module to create directories
$path = "./modules/create_directory.php?file=" . $file;
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
                    <div class="modal-body">
                        <form action=<?= $path ?> method="post">
                            <input type="text" id="defaultForm-name" name="directory-name" placeholder="Insert directory name" class="form-control validate">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->

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