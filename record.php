<?php
@include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <div class="Container">
        <h2 align="center">USER RECORD</h2>
        <div class="table-responsive">
            <!-- <p>Update user info with jquery ajax</p> -->
            <table class="table table-bordered table-striped" align="center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>Action</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $table = mysqli_query($conn, 'SELECT * FROM user_form');
                    while ($row = mysqli_fetch_array($table)) {
                        $statusText = ($row['status'] == 1) ? 'Active' : 'Inactive';
                        $statusClass = ($row['status'] == 1) ? 'active' : 'inactive';
                        $nextStatus = ($row['status'] == 1) ? 0 : 1;
                    ?>

                        <tr id="<?php echo $row['id'];  ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" height='100px' width='100px'></td>
                            <td data-target="name"><?php echo $row['name']; ?></td>
                            <td data-target="email"><?php echo $row['email']; ?></td>
                            <td><a data-role="update" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#myModal"><input type='submit' value='Update' class='update'></a>
                                <a href='delete_page.php?id=<?php echo $row['id']; ?>'><input type='submit' value='Delete' class='delete' onclick='return checkdelete()'></a>
                            </td>
                            <td>
                                <a href='status.php?id=<?php echo $row['id']; ?>&status=<?php echo $nextStatus; ?>'><input type='submit' value='<?php echo $statusText; ?>' class='<?php echo $statusClass; ?>'></a>

                            </td>
                        </tr>
                    <?php }
                    ?>

                </tbody>
            </table>

        </div>

        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update User Details</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label>User Name</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                    <div>
                        <label>User Email</label>
                        <input type="text" id="email" class="form-control">
                    </div>
                    <input type="hidden" id="userId" class="form-control">
                </div>
                <div class="modal-footer">
                    <a href="#" id="save" class="btn btn-primary pull-right">Update</a>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(document).on('click', 'a[data-role=update]', function() {
            // alert($(this).data('id'));
            var id = $(this).data('id');
            var name = $('#' + id).children('td[data-target=name]').text();
            var email = $('#' + id).children('td[data-target=email]').text();

            $('#name').val(name);
            $('#email').val(email);
            $('#userId').val(id);
            $('#myModel').modal('toggle');

        });

        $('#save').click(function() {
            var id = $('#userId').val();
            var name = $('#name').val();
            var email = $('#email').val();

            $.ajax({
                url: 'config.php',
                method: 'post',
                data: {
                    name: name,
                    email: email,
                    id: id
                },
                success: function(response) {
                    // console.log(response);/
                    $('#' + id).children('td[data-target=name]').text(name);
                    $('#' + id).children('td[data-target=email]').text(email);
                    $('#myModel').modal('hide');

                }

            });


        });
    });
</script>
<script>
    function checkdelete() {
        return confirm('Are You Sure Want to Delete this Record?');
    }
</script>

</html>