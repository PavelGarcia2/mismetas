<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link href="../styles/index.css" rel="stylesheet" type="text/css" />
    <title>Iniciar sesión</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="logo d-flex justify-content-center">
            <h1>Taskats</h1>
        </div>

        <!-- Fetching the tasks of today which are not completed!-->
        <?php
        //$json = file_get_contents('../../../tasks.json');
        //$json_data = json_decode($json, true);
        //$json_encoded_data = json_encode($json_data["tasks"]);

        // Display data 
        //print_r($json_data["tasks"]);
        $ch = curl_init("http://localhost/taskatsApiRest/dailytasks/"); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $dataApi = curl_exec($ch);

        curl_close($ch);
        $json_data = json_decode($dataApi, true);
        print_r($json_data);


        $dailyScore = 0;
        if ($json_data["status"] != 'error') {
            $json_encoded_data = json_encode($json_data["tasks"]);
            foreach ($json_data["tasks"] as $value) {
                if ($value["Status"]) {
                    $dailyScore += $value["Punctuation"];
                }
            }
        }
        ?>

        <div class="container">
            <div class="add_wrapp">
                <input type="text" class="todo_name">
                <button class="add_todo">Add</button>
            </div>
            <h5 style="color: #ffd700;">Score : <?php echo $dailyScore ?></h5>
            <div class="todo_wrapp">
                <div class="wrapper scrollable-inv">
                    <?php if ($json_data["status"] != 'error') :
                        foreach ($json_data["tasks"] as $value) : ?>
                            <div class="item" cid=<?php echo $value["ID"] ?> data-status=<?php echo $value["Status"] ?>>
                                <div class="delete">
                                    <input type="checkbox" id=<?php echo $value["ID"] ?> value="second_checkbox" <?php if ($value["Status"]) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> />
                                </div>
                                <h5><?php echo $value["Name"] ?></h5>

                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            // Sample JSON data with tasks
            var tasks = <?php echo $json_encoded_data; ?>;
            // Loop through tasks to dynamically generate CSS styles
            tasks.forEach(task => {
                let color = task.Color.toLowerCase(); // Convert color to lowercase

                // Define a CSS rule for each task status and color
                let style = `
                .item[cid="${task.ID}"] {
                    background-color: ${color};
                    
                }

                input[id="${task.ID}"] {
                    accent-color: ${color};
                    
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