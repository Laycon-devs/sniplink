<?php include "config.php" ?>
<?php
// inserting
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sniplink'])) {
    $inserting = $connection->prepare("INSERT INTO urls (links) VALUES(:lnk)");
    $inserting->bindParam(":lnk", $_POST['sniplink']);
    $inserting->execute();
    header("Location: index.php");
    die();
}
// selecting
$selecting = $connection->prepare("SELECT * FROM urls");
$selecting->execute();
$row = $selecting->fetchAll(PDO::FETCH_BOTH);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnipLnk - URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            margin-top: 50px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">SnipURL - URL Shortener</h1>
        <form action="index.php" method="POST" class="mb-5">
            <div class="input-group">
                <input name="sniplink" type="url" class="form-control" id="urlInput" placeholder="https://example.com" aria-label="Enter URL to Shorten">
                <div class="input-group-append">
                    <button name="btn" id="btn" class="btn btn-primary" type="submit">Shorten URL</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Original URL</th>
                    <th scope="col">Shortened URL</th>
                    <th scope="col">Clicks</th>
                    <th scope="col">Copy</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row -->
                <?php foreach ($row as $value) :  ?>
                    <tr>
                        <th scope="row"><?= $value["id"] ?></th>
                        <td><?= $value["links"] ?></td>
                        <td><a id="refresh" href="http://localhost/sniplink/main.php?id=<?= $value['id'] ?>" target="_blank">https://localhost/sniplink/<?= $value['id'] ?></a></td>
                        <td><?= $value["clicks"] ?></td>
                        <td><i id="clipboard" class="bi bi-clipboard" style="font-size: 2rem; color: cornflowerblue;"></i></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Add more rows here -->
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#btn").click(function(e) {
                // e.preventDefault();
                if ($("#urlInput").val() == "") {
                    alert("Link box can't be empty")
                }
            });
            $("#refresh").click(function () {
                setInterval(() => {
                    $('body').load('index.php')
                    console.log("reloaded");
                }, 5000);
            })
        })
    </script>
</body>

</html>