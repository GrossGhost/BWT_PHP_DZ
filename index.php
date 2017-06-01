<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require __DIR__  . '\DB.php';
        require __DIR__ . '\DBQuery.php';
        
        $db = DB::connect('mysql:dbname=mail;host=localhost','root','');
                
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = new DBQuery($db);
        
        echo '<br><br>queryAll<br><br>';
        print_r($query->queryAll('SELECT * FROM users', $dat));
        echo '<br><br>queryRow<br><br>';
        print_r($query->queryRow('SELECT * FROM users'));
        echo '<br><br>queryColumn<br><br>';
        print_r($query->queryColumn('SELECT email FROM users'));
        echo '<br><br>queryScalar<br><br>';
        echo $query->queryScalar('SELECT login FROM users');
        echo '<br><br>';
        
        $data = [':login' => 'Red' . rand(1,99999), ':email' => 'green+' . rand(1,99999) . '@gmail.com',':password' => password_hash('qwerty' . time() ,PASSWORD_DEFAULT)];
        echo '<br>execute<br>';
        
        $rowCount = $query->execute("DELETE FROM users WHERE id > :id", ['id' => 20]);
        echo "count deleted row -> " . $rowCount;
                         
        $rowCount = $query->execute("INSERT INTO users (login, email, password) VALUES (:login,:email,:password)", $data);

        echo "<br>count inserts row -> " . $rowCount;
        
        
        
        $db->reconnect();
        $lastId = $db->getLastInsertID();
        echo "<br><br>last InsertID -> " . $lastId;
        echo '<br>';
        print_r($query->queryRow("SELECT * FROM users where id = :id", ['id' => $lastId]));
        
        $updateData = ['password' => password_hash('qwerty' . time() ,PASSWORD_DEFAULT),'id' => $lastId];

        $rowCountUpdate = $query->execute("Update `users` SET password = :password where id = :id", $updateData);
        echo "<br>count update row -> " . $rowCountUpdate;
        
        $rowCountDelete = $query->execute("DELETE FROM `users` where id = :id", ['id' => $lastId]);
        echo "<br>count delete row -> " . $rowCountDelete;
        
        echo "<br>last query execution time -> ".$query->getLastQueryTime() . "\n";
        $db->close();
         
        ?>
    </body>
</html>
