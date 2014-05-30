<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Dashboard</h1>

            <div class="row placeholders col-lg-offset-1">
                <div class="col-xs-6 col-sm-2 placeholder">
                    <h4>Auth</h4>
                    <span class="label label-primary">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-2 placeholder">
                    <h4>Controller</h4>
                    <span class="label label-primary">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-2 placeholder">
                    <h4>Model</h4>
                    <span class="label label-primary">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-2 placeholder">
                    <h4>View</h4>
                    <span class="label label-primary">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-2 placeholder">
                    <h4>CRUD</h4>
                    <span class="label label-primary">Something else</span>
                </div>
            </div>

            <h2 class="sub-header">Table</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="5%">No</th>
                            <th width="15%">Table Name</th>
                            <th width="15%">Controller Name</th>
                            <th width="15%">Model Name</th>
                            <th width="7%">Auth</th>
                            <th width="7%">Controller</th>
                            <th width="7%">Model</th>
                            <th width="7%">View</th>
                            <th width="7%">Crud</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tables as $key => $value) :
                            $col = array_keys($value);
                            $col = reset($col);
                            $name = explode('_', $value[$col]);
                            $name = array_map("ucwords", $name);
                            $name = implode('', $name);
                            $model = 'M' . lcfirst($name);
                            ?>
                            <tr>
                                <td>
                                    <input type="radio" name="table" value="<?php echo $value[$col] ?>">
                                </td>
                                <td>
                                    <?php echo ($key + 1) ?>
                                </td>
                                <td>
                                    <?php echo $value[$col] ?>
                                </td>
                                <td>
                                    <input type="text" class="form-control" onchange="changeController(this)" table="<?php echo $value[$col] ?>" value="<?php echo $name ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?php echo 'M' . lcfirst($name) ?>" id="<?php echo $value[$col] ?>_model_input">
                                </td>
                                <td>
                                    <a href="?mode=auth&table=<?php echo $value[$col] ?>" id="<?php echo $value[$col] ?>_auth">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="?mode=controller&table=<?php echo $value[$col] . '&controller=' . $name . '&model=' . $model ?>" id="<?php echo $value[$col] ?>_controller">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="?mode=model&table=<?php echo $value[$col] . '&controller=' . $name . '&model=' . $model ?>" id="<?php echo $value[$col] ?>_model">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="?mode=view&table=<?php echo $value[$col] ?>" id="<?php echo $value[$col] ?>_view">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="?mode=crud&table=<?php echo $value[$col] ?>" id="<?php echo $value[$col] ?>_crud">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function changeController(data) {
        table = $(data).attr('table');
        controller = $(data).val();
        model = $('#' + table + "_model_input").val();
        window.console.log(table + ' ' + ' ' + controller + ' ' + model);
        $('#' + table + '_controller').attr('href', '?mode=controller&table=' + table + '&controller=' + controller + '&model=' + model);
        $('#' + table + '_model').attr('href', '?mode=model&table=' + table + '&model=' + model);

    }
</script>
