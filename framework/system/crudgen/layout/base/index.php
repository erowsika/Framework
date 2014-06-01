<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="page-header">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <div class="panel-body">
                    <form action="" method="get" id="form_table">
                        <div class="row col-lg-offset-2">
                            <div class="col-xs-6 col-sm-2 placeholder">
                                <h4>Auth</h4>
                                <button class="btn btn-danger" type="submit" name="mode" value="auth"><i class="glyphicon glyphicon-user"></i>  Create</button>
                            </div>
                            <div class="col-xs-6 col-sm-2 placeholder">
                                <h4>Controller</h4>
                                <button class="btn btn-primary" type="submit" name="mode" value="controller"><i class="glyphicon glyphicon-user"></i>  Create</button>
                            </div>
                            <div class="col-xs-6 col-sm-2 placeholder">
                                <h4>Model</h4>
                                <button class="btn btn-success" type="submit" name="mode" value="model"><i class="glyphicon glyphicon-user"></i>  Create</button>
                            </div>
                            <div class="col-xs-6 col-sm-2 placeholder">
                                <h4>View</h4>
                                <button class="btn btn-info" type="submit" name="mode" value="view"><i class="glyphicon glyphicon-user"></i>  Create</button>
                            </div>
                            <div class="col-xs-6 col-sm-2 placeholder">
                                <h4>CRUD</h4>
                                <button class="btn btn-warning" type="submit" name="mode" value="crud"><i class="glyphicon glyphicon-user"></i>  Create</button>
                            </div>
                        </div>

                        <h2 class="sub-header">Table</h2>
                        <div class="table-responsive" style="max-height: 400px; overflow: auto">
                            <input type="hidden" name="table" id="table" value="">
                            <input type="hidden" name="controller" id="controller" value="">
                            <input type="hidden" name="model" id="model" value="">

                            <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="5%">No</th>
                                        <th width="15%">Table Name</th>
                                        <th width="15%">Controller Name</th>
                                        <th width="15%">Model Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($tables as $key => $value) :
                                        $col = array_keys($value);
                                        $col = reset($col);
                                        $table = $value[$col];
                                        $controller = explode('_', $table);
                                        $controller = array_map("ucwords", $controller);
                                        $controller = implode('', $controller);
                                        $model = 'M' . lcfirst($controller);
                                        ?>
                                        <tr>
                                            <td><input type="radio" onchange="changeTable(this)" name="table" value="<?php echo $table ?>"></td>
                                            <td><?php echo ($key + 1) ?></td>
                                            <td><?php echo $table ?></td>
                                            <td><input type="text" class="form-control" onchange="$('#controller').val(this.value)" value="<?php echo $controller ?>" id="<?php echo $table ?>_controller_input"></td>
                                            <td><input type="text" class="form-control" onchange="$('#model').val(this.value)" value="<?php echo $model ?>" id="<?php echo $table ?>_model_input"></td>
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
    <script>
        $("form_table").submit(function(e) {
            alert('submit intercepted');
            e.preventDefault(e);
        });
        function changeTable(elem) {
            table = $(elem).val();
            controller = $('#' + table + "_controller_input").val();
            model = $('#' + table + "_model_input").val();
            $('#table').val(table);
            $('#controller').val(controller);
            $('#model').val(model);
        }

    </script>
