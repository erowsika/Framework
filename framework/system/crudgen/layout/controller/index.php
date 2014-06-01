<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="page-header">
                    <h1 class="page-header">Controller <?php echo App::instance()->input->get('table') ?> </h1>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] ?>&action=write_file" class="btn btn-success"><i class="glyphicon glyphicon-file"></i>  Write to file</a>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] ?>&action=download" class="btn btn-danger"><i class="glyphicon glyphicon-download"></i> Download</a>

                </div>
                <div class="panel-body">
                    <div class="panel panel-body">
                        <div style="height: 400px;overflow: auto">
                            <pre id="code">
                                <?php echo $code; ?>
                            </pre>
                            <textarea id="code_copy" class="col-sm-12 form-control" style="display: none;height: 400px">
                                <?php echo $code; ?>
                            </textarea>>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#code').click(function() {
                $(this).hide();
                $('#code_copy').show();
            })

            $('#code_copy').onblur(function() {
                $(this).hide();
                $('#code').show();
            })
        </script>