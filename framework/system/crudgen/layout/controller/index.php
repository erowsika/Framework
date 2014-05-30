<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8 col-lg-offset-1">
            <h1 class="page-header">Result</h1>
            <div class="panel panel-success">
                <div class="panel panel-header">
                    <h1> <?php echo App::instance()->input->get('table') ?> </h1>
                    <a href="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] ?>&action=write_file" class="btn btn-success"><i class="glyphicon glyphicon-file"></i>  Write to file</a>
                    <a href="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] ?>&action=download" class="btn btn-danger"><i class="glyphicon glyphicon-download"></i> Download</a>
                </div>
                <div class="panel panel-body">
                    <div style="height: 400px;overflow: auto">
                        <pre>
                            <?php echo $result; ?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>