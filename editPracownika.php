<?php

	session_start(); // dzięki temu podstrona może korzystać ze zmiennych globalnych
	
	if(!isset($_SESSION['zalogowany']))	//by uniknąć że ktoś niezalogowany wpisze kod w adresie i przejdzie na tą stronę
	{
		header('Location: index.php');
		exit();			// w takim przypadku przenieś na str main (zalogowaną) i pomiń poniższy kod (z tej str index)
	}else
	{
	
	
	
		//Poniżej - przetważanie naszego formularza:
		if(isset($_POST['aktualizuj']))
				{
										
					require_once "connect.php";

					$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);

					if($polaczenie->connect_errno!=0)
					{
						echo "Error: ".$polaczenie->connect_errno;
					}
					else
					{
						$id_pracownika=$_POST['idPrac'];
						$imie=$_POST['imie'];
						$nazwisko=$_POST['nazwisko'];
						$umowa=$_POST['umowa'];
						$okrUmowy=$_POST['okrUmowy'];
						$badania=$_POST['badania'];
						$budowa=$_POST['budowa'];
						$stawka=$_POST['stawka'];
						$opisUwagi=$_POST['opisUwagi'];
						
						$sql1="UPDATE pracownicy SET imie='$imie', nazwisko='$nazwisko', umowa='$umowa', okrUmowy='$okrUmowy', lekarskie='$badania', budowa='$budowa', stawka='$stawka', opisPr='$opisUwagi' WHERE id='$id_pracownika'";
						if($rezult=$polaczenie->query($sql1))						
						{
							$_SESSION['edytowanoPracownika']="zaktualizowano pracownika: ".$imie." ".$nazwisko;
							header('Location: pracownicy.php');
							unset($_POST['aktualizuj']);		
							
						}else { echo "Wystąpił problem  zaktualizacją pracownika";}

						$polaczenie->close();
					}
														
					
				}else if(isset($_POST['anuluj']))
				{
					header('Location: pracownicy.php');
					unset($_POST['anuluj']);
				};
	}
	
	?>