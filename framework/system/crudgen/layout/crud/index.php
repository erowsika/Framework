<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="page-header">
                    <h1 class="page-header">Model Generator</h1>
                </div>
                <div class="panel-body">
                    <div class="panel panel-body">
                        <?php if (isset($code)): ?>
                            <div style="height: 400px;overflow: auto">
                                <pre id="code">
                                    <?php echo $code; ?>
                                </pre>
                                <textarea id="code_copy" class="col-sm-12 form-control" style="display: none;height: 400px">
                                    <?php echo $code; ?>
                                </textarea>>
                            </div>
                            <hr>
                        <?php endif; ?>
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
                                            <th width="7%">Type Form</th>
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
                                                <td>
                                                    <select name="typeform_<?php echo $value['name'] ?>" class="form-control">
                                                        <option value="text">text</option>
                                                        <option value="number">number</option>
                                                        <option value="file">file</option>
                                                        <option value="checkbox">checkbox</option>
                                                        <option value="radio">radio</option>
                                                        <option value="email">email</option>
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