<table>
  <tr><th>Pseudo</th><th>Email</th><th>Date</th><th>Action</th></tr>
<?php
foreach ($listUsers as $users)
{
    
  echo '<tr>
		  <td>', $users['pseudos'], '</td>
		  <td>', $users['email'], '</td>
      <td>le ', $users['indate']->format('d/m/Y à H\hi'), '</td>
		  <td><a href="profil-update-', $users['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> 
		  </td>
       </tr>', "\n";
}
?>
</table>