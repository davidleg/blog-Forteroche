<script>
<!--
function disable()
{
	document.getElementById("newPass").disabled = true;
	
	var submitForm = document.getElementById("newPassForm"); 
	submitForm.submit() ;
	
}

function bloc ( lettre ) {
if ( document.formulaire.password.value.length < 12 ) document.formulaire.password.value = document.formulaire.password.value + lettre;
if ( document.formulaire.wordtok.value.length < 12 ) document.formulaire.wordtok.value = document.formulaire.wordtok.value + lettre;
}
-->
</script>

<?php 
	if( isset($form) && isset($valueHidden) )
	{
		$echo = "" ;
		$echo .= "<h2>Mon nouveau mot de passe !</h2> " ;
		$echo .= "<p> Veuillez Choisir un nouveau mot de passe et le confirmez, merci </p> " ;
		
		$echo .= "<form id='newPassForm' name='formulaire'   action='' method='post'> " ;
		
		$echo .= "<p style='float:right;margin-top:5px;margin-right:30%;'><img src='../../../images/users/password.png' usemap='#map' border='3px #CCC solid=' /> </p>";
		
		$echo .= "<p>".$form."</p>" ;
		
		$echo .= "<p>".$map."</p>" ;
		
		$echo .= "<input style='margin-left:10px;' type='reset' name='corriger' id='corriger' value='Corriger' /> ";
		$echo .= "<input type='submit' id='newPass' onclick='disable()' value='Valider' /> " ;
		
		$echo .= "<input type='hidden' name='wordtok'   value='' />  ";
		
		$echo .= " <input type='hidden' name='tok'   value=" . $valueHidden . " /> " ;
		$echo .= "</form>" ;	
		
		echo $echo ;
	}
?>


