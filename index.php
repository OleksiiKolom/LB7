<!-- "Варіант 6" -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>

    <script>
        function rentOfDate(url, callback, format) {
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
            const costRent = document.getElementById('costRent').value;
            rentOfDate('RentOfDate.php?costRent=' + costRent,
                function(response) {
                    console.log(response);
                    document.getElementById('res1').innerHTML = response;
                },
                'json');
        }
    </script>
    <script>
        function vendorCars(url, callback, format) {
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
            vendorCars('VendorCars.php?vendor=' + vendor,
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
        function FreeCars() {
            const ajax = new XMLHttpRequest();
            const FreeCarsValue = document.getElementById("FreeCars").value;

            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4) {
                    if (ajax.status === 200) {
                        console.log(ajax);
                        document.getElementById("res3").innerHTML = ajax.response;
                    }
                }
            };

            ajax.open("GET", "FreeCars.php?FreeCars=" + FreeCarsValue);
            ajax.send();
        }
    </script>

</head>

<body>
    <h2>Отриманий дохід з прокату станом на обрану дату</h2>
    <select name="costRent" id="costRent">
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
        <tbody id="res1"></tbody>
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
    <select name="FreeCars" id="FreeCars">
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
    <input type="button" value="Результат" onclick="FreeCars()">
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