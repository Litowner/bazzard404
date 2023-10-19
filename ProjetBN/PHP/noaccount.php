<html>
    <link rel="stylesheet" href="../css/indexcss.css">
    <head>
        <title>Créer un compte</title>
    </head>
    <body>
        <ul>
            <li><button><a class="active" href="../index.php">Accueil</a></button></li>
            <li><button><a href="ensavoirplus.php">En savoir plus</a></button></li>
            <li style="float:right"><button><a href="contact.php">Contact</a></button></li>  
        </ul>
        <div class="placeduformulaire">
                <form action="?" method="POST"> 
                    
                        
                            <label for="pseudo">Pseudo</label>
                            <input type="text" id="username" name="username" required> <br> <br>
                        
                        
                            <label for="email">Votre email</label>
                            <input type="email" id="mail" name="mail" placeholder="exemple@exemple.com" required> <br> <br>
                        
                        <label>Mot de passe</label>
                        <input type="password" id="password" name="password" required> <br> <br>
                        
                        <button type="submit">Créer le compte</button>
                        <br><br>
                        
                    

                </form>
                <a href="seconnecter.php"><button>Déjà un compte ?</button></a>
        </div>
    </body>
    <?php
    if(array_key_exists("username",$_POST))
    {
        if(array_key_exists("mail",$_POST))
        {
            if(array_key_exists("password",$_POST))
            {
                $username = $_POST["username"];
                $mail = $_POST["mail"];
                $password = $_POST["password"];
                
                if(mailAlreadyExist($mail))
                {
                    header("Location: controlmailexist.php");
                    //<script> alert("un compte existant est déjà lié à cette adresse email") </script>
                }
                elseif(usernameAlreadyExist($username))
                {
                    header("Location: controlusernameexist.php");
                    //<script> alert("un compte existant possède déjà ce pseudo")</script>
                }
                else
                {
                    $content = file_get_contents("../csv/users.csv");
                    $lines = explode("\n", $content);
                    $i=-1;
                    foreach($lines as $l)
                    {
                        $i++;
                        $data = str_getcsv($l,";");
                    }
                    $i++;
                    $data = array($i,$username,password_hash($password, PASSWORD_DEFAULT),$mail);
                    $handle = fopen('../csv/users.csv', 'a');
                    if(($handle = fopen('../csv/users.csv', "a")) !== FALSE) 
                    {
                        fputcsv($handle, $data, ";");
                
                        fclose($handle); 
                    }
                }
                
            }
        }
    }
    function mailAlreadyExist($mail)
                {
                    $content = file_get_contents("../csv/users.csv");
                    $lines = explode("\n", $content);
                    foreach($lines as $l)
                    {
                        $data = str_getcsv($l,";");

                        if($mail === $data[3])
                        {
                         return true;   
                        }
                        else
                        {
                            return false;
                        }
                    }
                }
                
                function usernameAlreadyExist($username)
                {
                    $content = file_get_contents("../csv/users.csv");
                    $lines = explode("\n", $content);
                    foreach($lines as $l)
                    {
                        $data = str_getcsv($l,";");

                        if($username === $data[1])
                        {
                            return true;
                        }
                        else
                        {
                            return false;
                        }
                    }
                }




    ?>



</html>