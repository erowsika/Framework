<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Result</h1>
            <div class="panel panel-success">
                <div class="panel panel-header">
                    <h1> <?php echo App::instance()->input->get('table') ?> </h1>
                </div>
                <div class="panel panel-body">

                    <div style="height: 400px;overflow: auto">
                        <pre>
                            <?php echo $code; ?>
                        </pre>
                    </div>
                    <form action="" method="post">
                        <button type="submit" name="action" value="write_file" class="btn btn-danger"><i class="glyphicon glyphicon-file"></i>  Write to file</button>
                        <button type="submit" name="action" value="download" class="btn btn-success"><i class="glyphicon glyphicon-download"></i>  Download</button>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="1%">No</th>
                                        <th width="15%">Name</th>
                                        <th width="10%">Label</th>
                                        <th width="7%">Type</th>
                                        <th width="3%">Required</th>
                                        <th width="3%">Min</th>
                                        <th width="3%">Max</th>
                                        <th width="3%">Trim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($columns as $key => $value) : ?>
                                        <tr>
                                            <td><input type="checkbox" name="col_<?php echo $value['name'] ?>" value="<?php echo $value['name'] ?>" checked></td>
                                            <td><?php echo ($key + 1) ?></td>
                                            <td><?php echo $value['name'] ?></td>
                                            <td><input type="text" name="label_<?php echo $value['name'] ?>" class="form-control" value="<?php echo $value['name'] ?>"></td>
                                            <td>
                                                <select name="type_<?php echo $value['name'] ?>" class="form-control">
                                                    <option value="string">string</option>
                                                    <option value="numeric">numeric</option>
                                                    <option value="email">email</option>
                                                    <option value="url">url</option>
                                                    <option value="ipv4">ipv4</option>
                                                    <option value="ipv6">ipv6</option>
                                                </select>
                                            </td>
                                            <td><input type="checkbox" name="required_<?php echo $value['name'] ?>" checked></td>
                                            <td><input type="text" name="min_<?php echo $value['name'] ?>" class="form-control" value="0"></td>
                                            <td><input type="text" name="max_<?php echo $value['name'] ?>" class="form-control" value="50"></td>
                                            <td><input type="checkbox" name="trim_<?php echo $value['name'] ?>" checked></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>