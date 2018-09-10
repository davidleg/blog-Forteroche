<h2 class="pushMargin">liste des commentaires du billet <?= $newsId ?> </h2>

<table class="tableAdmin">
  <tr><th>Auteur</th><th>Contenu</th><th>Date</th><th>Action</th></tr>
<?php

foreach ($comments as $comment)
{
   
   if (strlen($comment->contenu()) > 80)
      {
        $debut = substr($comment->contenu(), 0, 80);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $comment->setContenu($debut);
      }
    
   if( (string)$comment['status'] == "1"  )
    {
        $cho = '<tr style="background-color:rgba(250,250,250,0.7);" > ' ;
    }
    elseif( (string)$comment['status'] == "2"  )
    {
       $cho = '<tr style="background-color:rgba(250,0,0,0.2);" > ' ;
    }
    elseif( (string)$comment['status'] == "3"  )
    {
       $cho = '<tr style="background-color:rgba(100,100,100,0.2);" > ' ;
    }
    else{  $cho ='<tr>' ;}

  echo $cho.'
		  <td>', htmlspecialchars($comment['auteur']), '</td>
		  <td>', htmlspecialchars($comment['contenu']), '</td>
		  <td>le ', $comment['date'], '</td>
		  <td><a class="pleft"  href="comment-update-', $comment['id'], '.html"><i class="fa fa-edit fa-lg "></i></a> 
		      <a class="pleft"  href="comment-delete-ask-',$newsId,'-',$comment['id'], '.html"><i class="fa fa-window-close fa-lg"></i></a>
		  </td>
       </tr>', "\n";
}

?>
</table>

