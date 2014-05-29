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

            <h2 class="sub-header">Section title</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="5%">No</th>
                            <th width="25%">Table Name</th>
                            <th width="10%">Auth</th>
                            <th width="10%">Controller</th>
                            <th width="10%">Model</th>
                            <th width="10%">View</th>
                            <th width="10%">Crud</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tables as $key => $value) :
                            $col = array_keys($value);
                            $col = reset($col);
                            ?>
                            <tr>
                                <td><input type="radio" name="table" value="<?php echo $value[$col] ?>"></td>
                                <td><?php echo ($key + 1) ?></td>
                                <td><?php echo $value[$col] ?></td>
                                <td><a href="?mode=auth&table=<?php echo $value[$col] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td><a href="?mode=controller&table=<?php echo $value[$col] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td><a href="?mode=model&table=<?php echo $value[$col] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td><a href="?mode=view&table=<?php echo $value[$col] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td><a href="?mode=crud&table=<?php echo $value[$col] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>