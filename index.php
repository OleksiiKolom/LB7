<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>

    <script>
        function rentofdate(url, callback, format) {
            const ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    if (format === 'json') {
                        console.log("json");
                        callback(JSON.parse(ajax.responseText));
                    }
                }
            };
            ajax.open('GET', url);
            ajax.send();
        }
        function rent() {
            const costrent = document.getElementById('costrent').value;
            rentofdate('rent.php?costrent=' + costrent,
                function(response) {
                    console.log(response);
                    document.getElementById('resultOfFirstHandler1').innerHTML = response;
                },'json');
        }
    </script>
    <script>
        function vendorcars(url, callback, format) {
            const ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    if (format === 'xml') {
                        console.log("xml");
                        callback(ajax.responseXML);
                    }
                }
            };
            ajax.open('GET', url);
            ajax.send();
        }

        function ven() {
            const vendor = document.getElementById('vendor').value;
            vendorcars('VendorCars.php?vendor=' + vendor,
                function(response) {
                    console.log(response);

                    const nodes = response.getElementsByTagName('vendor');
                    let list = '<ul>';
                    for (let i = 1; i < nodes.length; i++) {
                        list += '<li>' + nodes[i].childNodes[0].nodeValue + '</li>';
                    }
                    list += '</ul>';
                    document.getElementById('res2').innerHTML = list;
                },
                'xml');
        }
    </script>

    <script>
        function freecars() {
            const ajax = new XMLHttpRequest();
            const freecarsValue = document.getElementById("freecars").value;

            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4) {
                    if (ajax.status === 200) {
                        console.log(ajax);
                        document.getElementById("res3").innerHTML = ajax.response;
                    }
                }
            };

            ajax.open("GET", "freecars.php?freecars=" + freecarsValue);
            ajax.send();
        }
    </script>

</head>

<body>
    <h2>Отриманий дохід з прокату станом на обрану дату</h2>
    <select name="costrent" id="costrent">
        <?php
        include("connect.php");

        try {
            foreach ($dbh->query("SELECT DISTINCT Date_end FROM rent") as $row) {
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        ?>
    </select>
    <input type="button" value="Результат" onclick="rent()">
    <table border='1'>
        <tbody id="resultOfFirstHandler1"></tbody>
    </table>
    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <h2>Автомобілі обраного виробника</h2>
    <select name="vendor" id="vendor">
        <?php
        include("connect.php");

        try {
            foreach ($dbh->query("SELECT DISTINCT Name FROM vendors") as $row) {
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        ?>
    </select>
    <input type="button" value="Результат" onclick="ven()">
    <table border='1'>
        <tbody id="res2"></tbody>
    </table>

    <!---------------------------------------------------------------------------------------------------------------------------->

    <h2>Вільні автомобілі на обрану дату</h2>
    <select name="freecars" id="freecars">
        <?php
        include("connect.php");

        try {
            foreach ($dbh->query("SELECT DISTINCT Date_start FROM rent") as $row) {
                echo "<option value=$row[0]>$row[0]</option>";
            }
        } catch (PDOException $ex) {
            echo $ex->GetMessage();
        }
        ?>
    </select>
    <input type="button" value="Результат" onclick="freecars()">
    <table border='1'>
        <thead>
            <tr>
                <th>ID_Cars</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody id="res3"></tbody>

</body>

</html>