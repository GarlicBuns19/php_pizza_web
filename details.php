<?php

require('./config/db_connection.php');

if(isset($_POST['delete'])){

    $id_to_del = mysqli_real_escape_string($conn,$_POST['id_to_del']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_del";

    if(mysqli_query($conn,$sql)){
        // success
        header('Location: index.php');
        mysqli_close($conn);
    }else{
        // err
        echo 'query error:' . mysqli_error($conn);
    };

}

if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get query result
    $result = mysqli_query($conn, $sql);

    // fetch result in arr format
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}

?>

<!-- Header -->
<?php require('./templates/header.php') ?>


<center>
    <h1>Details</h1>
    <?php if ($pizza) : ?>
        <table>
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_del" value="<?php echo $pizza['id'] ?>">
                <button type="submit" name="delete">Delete</button>
            </form>
            <thead>
                <tr>
                    <td>id</td>
                    <td>Title</td>
                    <td>Ingredients</td>
                    <td>Email</td>
                    <td>Created At</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $pizza['id'] ?>
                    </td>
                    <td>
                        <?php echo $pizza['title'] ?>
                    </td>
                    <td>
                        <ul>
                            <?php foreach (explode(',', $pizza['ingredients']) as $ingredient) : ?>
                                <li> <?php echo $ingredient ?> </li>
                            <?php endforeach ;?>
                        </ul>
                    </td>
                    <td>
                        <?php echo $pizza['email'] ?>
                    </td>
                    <td>
                        <?php echo $pizza['created_at'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php else:?>
            <h1>No such pizza exist</h1>
    <?php endif ;?>
</center>

<!-- Footer -->
<?php require('./templates/footer.php') ?>