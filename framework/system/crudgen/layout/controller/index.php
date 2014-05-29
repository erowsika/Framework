<link rel="stylesheet" href="http://yandex.st/highlightjs/8.0/styles/default.min.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8 col-lg-offset-1">
            <h1 class="page-header">Result</h1>

            <div class="panel panel-success">
                <div class="panel panel-header">
                    <?php echo App::instance()->input->get('table') ?>
                </div>
                <div class="panel panel-body">
                    <div class="code">
                        <?php echo $result; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://yandex.st/highlightjs/8.0/highlight.min.js"></script>
<script>
    $('code').each(function(i, e) {
        hljs.highlightBlock(e)
    });
    hljs.initHighlightingOnLoad();
</script>