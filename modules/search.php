<div class="fm-search">
    <div class="mb-0">
        <!-- <form action="./scripts/search_files.php" method="post"> -->
        <div class="input-group input-group-lg">
            <span class="input-group-text bg-transparent">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control" name="search" id="search-input" placeholder="Search files">
            <!-- <input type="hidden" class="form-control" name="dir" value="../root/">
                <input type="submit" value="submit"> -->
        </div>
        <!-- </form> -->
    </div>
</div>

<script>
    $('#search-input').change(function(e) {
        e.preventDefault();
        dir = '<?= $_GET["file"] ?? "" ?>';
        search = $(this).val();

        $(this).val().length && $.post("./scripts/search_files.php", {
            search,
            dir,
        }, function(data) {
            console.log(data);
            // if (data.status) {
            //     window.location.reload();
            // } else {
            //     $('#renameForm-name').addClass('is-invalid');
            //     $('.renameForm-name').text(data.msg);
            //     console.log("Error doing ", data.action);
            // }
        }, 'json');
    });
</script>