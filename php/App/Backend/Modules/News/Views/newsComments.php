
<table>
  <tr><th>Auteur</th><th>Contenu</th><th>Date</th><th>Action</th></tr>
<?php
foreach ($comments as $comment)
{
   
   if (strlen($comment->contenu()) > 100)
      {
        $debut = substr($comment->contenu(), 0, 100);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $comment->setContenu($debut);
      }
    
  echo '<tr>
		  <td>', $comment['auteur'], '</td>
		  <td>', $comment['contenu'], '</td>
		  <td>le ', $comment['date']->format('d/m/Y à H\hi'), '</td>
		  <td><a href="comment-update-', $comment['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> 
		      <a href="comment-delete-ask-',$newsId,'-',$comment['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a>
		  </td>
       </tr>', "\n";
}
?>
</table>

