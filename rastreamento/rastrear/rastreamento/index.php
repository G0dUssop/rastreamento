<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreamento</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .input-container {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: left;
            font-size: 14px;
            color: #555;
        }

        .event {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 6px;
        }

        .event p {
            margin: 5px 0;
        }
</style>
<body>
   
<div class="container">
        <h1>Rastrear</h1>
        <form action="index.php" method="get">
            <div class="input-container">
                <input type="text" name="codigo" placeholder="Digite o código de rastreio" required>
            </div>
            <button type="submit">Buscar</button>
        </form>

    
     
    <?php
     if(isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.linketrack.com/track/json?user=teste&token=1abcd00b2731640e886fb41a8a9671ad1434c599dbaa0a0de9a5aa619f29a83f&codigo=$codigo",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $result = json_decode($response);

    if ($result && isset($result->eventos) && count($result->eventos) > 0) {
        echo "<div class='result'>";
        foreach ($result->eventos as $evento) {
            echo "<div class='event'>";
            echo "<p><strong>Data:</strong> " . $evento->data . "</p>";
            echo "<p><strong>Horário:</strong> " . $evento->hora . "</p>";
            echo "<p><strong>Status:</strong> " . $evento->status . "</p>";
            echo "<p><strong>Local:</strong> " . $evento->local . "</p>";
            
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p style='color: red;'>Nenhum evento encontrado para o código informado.</p>";
    }
}
?>

</div>
</body>
</html>