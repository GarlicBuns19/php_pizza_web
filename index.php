<?php
// echo 'Hello index';
require('./config/db_connection.php');

// query for all pizzas
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

// make query to get data
$result = mysqli_query($conn, $sql);

// fetch result rows as an arr
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection 
mysqli_close($conn);

// print_r($pizzas);

?>

<!-- Header -->
<?php require('./templates/header.php') ?>

    <!-- Pizzas -->
    <section class="pizza_conrainer">
        <center>
            <table>
                <thead>
                    <tr>
                        <td>
                            id
                        </td>
                        <td>
                            title
                        </td>
                        <td>
                            Ingredients
                        </td>
                        <td>
                            Info
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pizzas as $pizza){ ?>
                        <tr>
                            <td> <?php echo htmlspecialchars($pizza['id'])?> </td>
                            <td> <?php echo htmlspecialchars($pizza['title']) ?> </td>
                            <td> 
                                <ul>
                                    <!-- explode(via what,value) -->
                                    <!-- <php foreach(explode(',',$pizza['ingredients']) as $ingredient){ ?>  -->
                                    <?php foreach(explode(',',$pizza['ingredients']) as $ingredient): ?> 
                                        <li>
                                            <?php echo htmlspecialchars($ingredient) ?>
                                        </li>    
                                    <?php endforeach ?>
                                    <!-- <php } ?> -->
                                </ul>
                            </td>
                            <td>
                                <a href="details.php?id=<?php echo $pizza['id'] ?>">More info</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr></tr>
                </tbody>
            </table>
        </center>
    </section>

<!-- Footer -->
<?php require('./templates/footer.php') ?>