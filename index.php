<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>FileSystem Explorer</title>
</head>

<body>
    <div class="container">
        <div class="card-body">
            <!-- <div class="d-grid"> <a href="javascript:;" class="btn btn-primary">+ Add File</a>
            </div> -->
            <!-- <form action="./modules/create_directory.php" method="post">
                <input type="submit" class="btn btn-primary" value="+ Add File">
            </form> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                + Add Directory
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
                            <!-- <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label> -->
                            <form action="./modules/create_directory.php" method="post">
                                <!-- <input type="submit" class="btn btn-primary" value="+ Add File"> -->
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

            <h5 class="my-3">My Drive</h5>
            <div class="fm-menu">
                <div class="list-group list-group-flush"> <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-folder me-2"></i><span>All Files</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-devices me-2"></i><span>My Devices</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-analyse me-2"></i><span>Recents</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Important</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-trash-alt me-2"></i><span>Deleted Files</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-file me-2"></i>
                        <span>Documents</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-image me-2"></i><span>Images</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-video me-2"></i><span>Videos</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-music me-2"></i><span>Audio</span></a>
                    <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-beer me-2"></i><span>Zip Files</span></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>