<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <link href="../styles/projects.css" rel="stylesheet" type="text/css" />
    <title>Iniciar sesión</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="logo d-flex justify-content-center">
            <h1>Taskats Projects</h1>
        </div>

        <!-- Fetching the tasks of today which are not completed!-->
        <?php
        //$json = file_get_contents('../../../tasks.json');
        //$json_data = json_decode($json, true);
        //$json_encoded_data = json_encode($json_data["tasks"]);

        // Display data 
        //print_r($json_data["tasks"]);
        $ch = curl_init("http://localhost/taskatsApiRest/projects/"); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $dataApi = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($dataApi, true);
        $json_encoded_data = json_encode($json_data["projects"]);
        ?>


        <div class="container">

            <?php foreach ($json_data["projects"] as $value) : ?>
                <div class="item" cid=<?php echo $value["project_id"] ?>>
                    <h5><?php echo $value["name"] ?></h5>

                </div>

            <?php endforeach; ?>
            <button class="add_project"><div>+</div> <span>Create Project</span></button>

        </div>

        <script>
            // Sample JSON data with tasks
            var tasks = <?php echo $json_encoded_data; ?>;
            console.log(tasks);
            // Loop through tasks to dynamically generate CSS styles
            tasks.forEach(task => {
                let color = task.color.toLowerCase(); // Convert color to lowercase

                // Define a CSS rule for each task status and color
                let style = `
                .item[cid="${task.project_id}"] {
                    background-color: ${color};
                }

                .item[cid="${task.project_id}"]:hover {
                    background-color: #ffffff;
                }

                input[id="${task.project_id}"] {
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