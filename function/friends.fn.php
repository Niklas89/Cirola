<?php

mysql_connect("localhost", "root", "root");
mysql_select_db("cirolaprod");  
mysql_query("SET CHARACTER SET 'utf8'");


class Friends
{

  private $lst_friend = array();
  private $lst_user = array();
  
  
  function getFriends()
  {
    if(isset($_GET['id']))
    {
      $get = 'SELECT users.id, users.fname, users.lname 
              FROM users 
              LEFT JOIN friends 
              ON users.id = friends.friend_id 
              WHERE friends.user_id="'.$_GET['id'].'"
              AND statut=1';
    }
    else
    {
      $get = 'SELECT users.id, users.fname, users.lname 
              FROM users 
              LEFT JOIN friends 
              ON users.id = friends.friend_id 
              WHERE friends.user_id="'.$_SESSION['id'].'"
              AND statut=1';
    }

    
    $had = mysql_query($get) or die(mysql_error());
    while($friend = mysql_fetch_array($had, MYSQL_ASSOC))
    {
      $this->lst_friend[] = $friend;
    }
    return $this->lst_friend;
  }
  
  
  
  
  function verifFriend()
  {
    if(isset($_GET['id']))
    {
      
      
      $ddeTrue = 'SELECT *
                  FROM friends
                  WHERE user_id="'.$_GET['id'].'" AND friend_id="'.$_SESSION['id'].'" AND statut=0';
                  
      $ddeVerif = mysql_query($ddeTrue);
      if(mysql_num_rows($ddeVerif) == 1)
      {
          echo '<a href="add.php?id='.$_GET['id'].'&skr=answer">Répondre à la demande d\'ajout à la liste d\'ami</a>';
      }
      else
      {
          $verif = 'SELECT * 
                FROM friends 
                WHERE user_id = "'.$_SESSION['id'].'" AND friend_id = "'.$_GET['id'].'"';
          $getVerif = mysql_query($verif);

          $row = mysql_fetch_array($getVerif, MYSQL_ASSOC);
          
          if(mysql_num_rows($getVerif) == 1)
          {
              if ($row['statut'] == 1)
              {
                echo 'Vous êtes déja ami avec cette personne';
              }
              elseif ($row['statut'] == 0)
              {
                echo 'Demande d\'ajout à la liste d\'ami en cours de vérification';
              }
          }
          else
          {
            echo '<a href="add.php?id='.$_GET['id'].'">Ajouter en Ami</a>';
          }
      }
    }
  }
  
  function getUserList()
  {
    $lst = 'SELECT id, name, firstName FROM users WHERE id!="'.$_SESSION['id'].'"';
    $requete = mysql_query($lst);
    while ($userList = mysql_fetch_array($requete, MYSQL_ASSOC))
    { 
          $this->lst_user[] = $userList;
    }
    return $this->lst_user;
  }
  
  function countDdeAmi()
  {
    $count = 'SELECT count(*) as nbdde FROM friends WHERE friend_id="'.$_SESSION['id'].'" AND statut=0';
    $countSend = mysql_query($count);
    $row = mysql_fetch_array($countSend);
    
    echo 'Vous avez '.$row['nbdde'].' demande d\'ajout à la liste d\'ami';
  }
  
}



class AddFriend
{
  private $friendId;
  
  function __construct()
  {
    $this->friendId = $_GET['id'];
  }
  
  function addFriend()
  {
    $verif='SELECT * FROM friends WHERE  user_id="'.$_SESSION['id'].'" AND friend_id="'.$this->friendId.'"';
    $verifsend = mysql_query($verif);
    if(mysql_num_rows != 0)
    {
      header('Location: profil.php?id='.$this->friendId.'');
    }
    else
    {
      $add = 'INSERT INTO friends SET user_id="'.$_SESSION['id'].'", friend_id="'.$this->friendId.'", statut=0';
      $send = mysql_query($add);
      header('Location: profil.php?id='.$this->friendId.'');
    }
  }
  
  function responseFriend()
  {
    $response = 'UPDATE friends SET statut=1 WHERE user_id="'.$this->friendId.'" AND friend_id="'.$_SESSION['id'].'"';
    $responseSend = mysql_query($response);
    $newAdd = 'INSERT INTO friends SET user_id="'.$_SESSION['id'].'", friend_id="'.$this->friendId.'", statut=1';
    $sensNew = mysql_query($newAdd);
    header('Location: profil.php?id='.$_GET['id'].'');
  }
}


?>