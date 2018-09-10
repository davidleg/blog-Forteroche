<table class="tableAdmin" >
  <tr><th>Auteur</th><th>Contenu</th><th>Date</th><th>Status</th><th>Raison</th><th>Action</th></tr>
<?php
foreach ($comments as $comment)
{
   
   if (strlen($comment->contenu()) > 80)
      {
        $debut = substr($comment->contenu(), 0, 80);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $comment->setContenu($debut);
      }
    
  echo '<tr>
		  <td>', htmlspecialchars($comment['auteur']), '</td>
		  <td>', htmlspecialchars($comment['contenu']), '</td>
		  <td>le ', $comment['date']->format('d/m/Y à H\hi'), '</td>
      <td>', htmlspecialchars($comment['status']), '</td>
      <td>', htmlspecialchars($comment['raison']), '</td>

		  <td><a class="pleft" href="comment-update-', $comment['id'], '.html"><i class="fa fa-edit fa-lg "></i></a> 
		      <a class="pleft" href="comment-delete-ask-',$comment['news'],'-',$comment['id'], '.html"><i class="fa fa-window-close fa-lg"></i></a>
		  </td>
       </tr>', "\n";
}
?>
</table>
