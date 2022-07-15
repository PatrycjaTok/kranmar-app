<?php

	session_start(); // dzięki temu podstrona może korzystać ze zmiennych globalnych
	
	if(!isset($_SESSION['zalogowany']))	//by uniknąć że ktoś niezalogowany wpisze kod w adresie i przejdzie na tą stronę
	{
		header('Location: index.php');
		exit();			// w takim przypadku przenieś na str main (zalogowaną) i pomiń poniższy kod (z tej str index)
	}else
	{
	
	
	
		//Poniżej - przetważanie naszego formularza:
	
					$id_urlopu=$_GET['zmiennaId'];
										
					//połączenie z bazą mySQL
					require_once "connect.php";

					$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);

					if($polaczenie->connect_errno!=0)
					{
						echo "Error: ".$polaczenie->connect_errno;
					}
					else
					{
						$id_uzytkownika=$_SESSION['id_uzytkownika'];
						$sql1="SELECT urlopy.id_pracownika FROM urlopy WHERE id_uzytkownika='$id_uzytkownika' AND id='$id_urlopu'";
						if($rezult=$polaczenie->query($sql1))						
						{
							$row=($rezult->fetch_assoc());
	
								$ktoid=$row['id_pracownika'];
										$sql_z6="SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko FROM pracownicy WHERE pracownicy.id='$ktoid'";
										if($rezult_z6=$polaczenie->query($sql_z6))
										{
											$row_z6=$rezult_z6->fetch_assoc();

											$ktosql6imie=$row_z6['imie'];
											$ktosql6nazwisko=$row_z6['nazwisko'];
											$ktoAnswer=$ktosql6nazwisko." ".$ktosql6imie;
										};
				
						}else { echo "BRAK DANYCH";}
						
						//usuwanie zastępstwa
						if(isset($_POST['del'])){
							$idUrlopu=$_POST['idUrlopu'];
							$sqlDel="DELETE FROM urlopy WHERE id='$idUrlopu'";
							if($rezultDel=$polaczenie->query($sqlDel))						
							{
								$_SESSION['usunietoUrlopKomunikat']="usunięto pozycję";
								unset($_POST['del']);
								echo "<script>
									window.close();
									if (window.opener && !window.opener.closed) {
										window.opener.location.href = 'urlopy.php';
									};
									</script> ";
									exit();
								header('Location: urlopy.php');
								
								
							}								
						
						unset($_POST['del']);
	
					}	
			$polaczenie->close();	
			
	}

}
	
	?>

<!DOCTYPE HTML>
<html lang="pl-PL">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale-=1">
		<link rel="stylesheet" href="css/style_pracownicydodaj.css" type="text/css">
		<link rel="stylesheet" href="css/style_littleBox_pr.css" type="text/css">
		<link rel="icon" href="images/favicon.png" type="image/x-icon">
		<title>Aplikacja do zarządzania ludźmi - dodaj pracownika</title>

		<style>
			@media screen and (max-width:640px){   
				body{
					font-size: 18px;
				}  					
			}
							
			@media screen and (min-width:640px) and (max-width:1024px){
				body{
					font-size: 20px;
				}				
			}
							
			@media screen and (min-width:1024px){
				body{
					font-size: 20px;
				}					
			}
							
			body{
				width: auto;
				background-color: rgb(146, 180, 129);
				font-family: georgia,tahoma, arial, sans-serif;
				margin:0;
			}
			
			.button1{
				background-color:  rgb(24, 121, 100);
				font-size: large;
				margin-top: 0.7em;
				cursor: pointer;
				box-shadow: 0 0.3em 0.3em rgba(0, 0, 0, 0.548);
				transition-property: box-shadow, background-color;
				transition-duration: 0.3s;
				border-radius: 5px;
			}
									
			.button1:hover{
				background-color:  rgb(22, 102, 85);
				box-shadow: 0 0.5em 0.5em rgba(0, 0, 0, 0.685)
			}
									
			.button1:active{
				background-color:  rgb(21, 87, 72);
				box-shadow: 0 0.5em 0.5em rgba(0, 0, 0, 0.801)
			}

			.button2{
				background-color: rgb(187, 37, 37);
				font-size: large;
				margin-top: 0.7em;
				cursor: pointer;
				box-shadow: 0 0.3em 0.3em rgba(0, 0, 0, 0.548);
				transition-property: box-shadow, background-color;
				transition-duration: 0.3s;
				border-radius: 5px;
			}
									
			.button2:hover{
				background-color: rgb(165, 32, 32);
				box-shadow: 0 0.5em 0.5em rgba(0, 0, 0, 0.685)
			}
									
			.button2:active{
				background-color: rgb(131, 23, 23);
				box-shadow: 0 0.5em 0.5em rgba(0, 0, 0, 0.801)
			}

			.okienko{
				padding:10px;
				text-align: center;
				margin-top: 22vh;
			}

			.marginleftbtn{
				margin-left: 20vw;
			};
		</style>
	</head>

	<body>

		<div class='okienko'> <form method='post'> Czy na pewno chcesz usunąć urlop:<br><b>
			

		<?php
			echo " ".$ktoAnswer."</b>? 				
			<br> <input type='hidden' name='idUrlopu' value='".$id_urlopu."'>";
					
		?>

		<input type='submit' name='del' value='usuń' class='button2'> <input type='submit' value='anuluj' class='button1 marginleftbtn' onclick='window.close()'></form></div>
	</body>
</html>