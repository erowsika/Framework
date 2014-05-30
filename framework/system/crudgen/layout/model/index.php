<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Result</h1>
            <div class="panel panel-success">
                <div class="panel panel-header">
                    <h1> <?php echo App::instance()->input->get('table') ?> </h1>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] ?>&action=write_file" class="btn btn-success"><i class="glyphicon glyphicon-file"></i>  Write to file</a>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] ?>&action=download" class="btn btn-danger"><i class="glyphicon glyphicon-download"></i> Download</a>
                </div>
                <div class="panel panel-body">
                    <h2 class="sub-header">Table</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="5%">No</th>
                                    <th width="15%">Column</th>
                                    <th width="15%">Label</th>
                                    <th width="15%">Model Name</th>
                                    <th width="7%">Auth</th>
                                    <th width="7%">Controller</th>
                                    <th width="7%">Model</th>
                                    <th width="7%">View</th>
                                    <th width="7%">Crud</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($columns as $key => $value) : ?>
                                    <tr>
                                        <td><input type="checkbox" name="col_<?php echo $value['name'] ?>" value="<?php echo $value['name'] ?>"></td>
                                        <td><?php echo ($key + 1) ?></td>
                                        <td><?php echo $value['name'] ?></td>
                                        <td><input type="text" name="label_<?php echo $value['name'] ?>" class="form-control" value="<?php echo $value['name'] ?>"></td>
                                        <td>
                                            <select name="type_<?php echo $value['name'] ?>" class="form-control">
                                                <option value="string">string</option>
                                                <option value="numeric">numeric</option>
                                                <option value="string">string</option>
                                                <option value="string">string</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>