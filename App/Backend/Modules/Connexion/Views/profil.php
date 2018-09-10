<h2 class="pushMargin">Données de mon profil </h2>

<table class="tableAdmin" >
  <tr><th>Pseudo</th><th>Email</th><th>Date</th><th>Action</th></tr>
<?php
foreach ($listUsers as $users)
{
    
  echo '<tr style="background-color:rgba(250,250,250,1);text-align:center;" >
		  <td>', $users['pseudos'], '</td>
		  <td>', $users['email'], '</td>
      <td>le ', $users['indate']->format('d/m/Y à H\hi'), '</td>
		  <td><a class="pleft"  href="profil-update-', $users['id'], '.html"><i class="fa fa-edit fa-lg "></i></a> 
		  </td>
       </tr>', "\n";
}
?>
</table>