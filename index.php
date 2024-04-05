<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link href="./index.css" rel="stylesheet" type="text/css" />
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="logo d-flex justify-content-center">
            <h1>Taskats</h1>
        </div>

        <!-- Fetching the tasks of today which are not completed!-->
        <?php
        $json = file_get_contents('tasks.json');
        $json_data = json_decode($json, true);
        $json_encoded_data = json_encode($json_data["tasks"]);

        // Display data 
        //print_r($json_data["tasks"]);
        ?>
        <div class="container">
            <div class="add_wrapp">
                <input type="text" class="todo_name">
                <button class="add_todo">Add</button>
            </div>
            <div class="todo_wrapp">
                <div class="wrapper scrollable-inv">
                    <?php foreach ($json_data["tasks"] as $value) : ?>

                        <div class="item" cid=<?php echo $value["ID"] ?> data-status="Not-Completed">
                            <h5><?php echo $value["Name"] ?></h5>
                            <div class="delete">x</div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script>
            // Sample JSON data with tasks
            console.log("Hola");
            var tasks = <?php echo $json_encoded_data; ?>;
            console.log(tasks);
            // Loop through tasks to dynamically generate CSS styles
            tasks.forEach(task => {
                let color = task.Color.toLowerCase(); // Convert color to lowercase

                // Define a CSS rule for each task status and color
                let style = `
                .item[cid="${task.ID}"] {
                    background-color: ${color};
                }
            `;

                // Create a style element and append it to the document's head
                let styleElement = document.createElement('style');
                styleElement.innerHTML = style;
                document.head.appendChild(styleElement);
            });
        </script>




    </main>
</body>

</html>