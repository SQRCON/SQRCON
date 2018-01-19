function rowaction(value, row, index)
{
  var output = '<div class="form-inline" style="white-space: nowrap !important;" role="form">';
  output = output + '<button class="btn btn-default btn-xs" data-toggle="modal" href="dialog.php?action=modal&id=' + row.ID +'" data-target="#modal"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
  output = output + '<button class="btn btn-danger btn-xs" data-toggle="modal" href="dialog.php?action=modal&id=' + row.ID +'" data-target="#modal"><i class="fa fa-trash"></i></button>';
  output = output + '</div>';
  return output;
}

function rowStyle(row, index)
{
    if (row.ID == 0) {
      return {
        classes: 'warning'
      };
    }
  return {};
}