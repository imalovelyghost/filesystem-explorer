<div class="fm-search">
    <div class="mb-0">
        <div class="input-group input-group-lg">
            <span class="input-group-text bg-transparent">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control" name="search" id="search-input" placeholder="Search files">
        </div>
    </div>
</div>

<script>
    $('#search-input').on('input', function(e) {
        e.preventDefault();
        const dir = '<?= $_GET["file"] ?? "" ?>',
            search = $(this).val();
        let formData = new FormData();
        formData.append("dir", dir);
        formData.append("search", search);
        $(this).val().length && $.post("./scripts/search_files.php", {
            search,
            dir,
        }, function(data) {
            list(data);
        }, 'json');
    });

    $('#search-input').blur(function(e) {
        if (!$(this).val().length) {
            $('.files-container').removeClass('d-none');
            $('.search-container').addClass('d-none');
        }
    });

    $('#search-input').keyup(function(e) {
        if (e.keyCode == 27) {
            $(this).val("");
        }
        if (!$(this).val().length) {
            $('.files-container').removeClass('d-none');
            $('.search-container').addClass('d-none');
        }
    });

    function list(data) {
        $('.files-container').addClass('d-none');
        $('.search-container').removeClass('d-none');
        $('.search-result').empty();

        if (data.results.length) {
            $.each(data.results, function(index, value) {
                const content = $("<div></div>")
                    .addClass('row border-bottom my-2')
                    .append($(`<div class='col-sm'>${value.icon} ${value.name}</div>`))
                    .append($(`<div class='col-sm'>${value.path}</div>`))
                    .append($("<div class='col-sm-2'></div>"));
                $('.search-result').append(content);
            })
        } else {
            $('.search-result').append("No results found");
        }

        $('a[data-type="iframe"], [data-type="image"]').each(function() {
            $(this).magnificPopup({
                type: $(this).attr('data-type'),
                src: $(this).attr('href'),
            });
        });
    }
</script>