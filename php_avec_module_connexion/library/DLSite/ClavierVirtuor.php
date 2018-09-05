<?php
namespace DLSite;

trait ClavierVirtuor
{
	/* 3 elements à placer */
	
	/* a placer dans la condition if post    */ 
	public function ifPost($data)
	{
		$tableau = $_SESSION["tableau"];	
		$password = $data;
		$passlist ='';
		for ($i=0; $i<strlen($password); $i++)
		{
			$tableau[$this->convert($password[$i])];
			$passlist .= (string)$tableau[$this->convert($password[$i])];		
		}
		return $passlist ;
	}
	public function convert ( $lettre ) 
	{
		$tab = array("A" => "0","B" => "1","C" => "2","D" => "3","E" => "4","F" => "5","G" => "6","H" => "7","I" => "8","J" => "9","K" => "10","L" => "11","M" => "12","N" => "13","O" => "14","P" => "15",);
		$lettre = strtr("$lettre", $tab);
		
		return $lettre;
	}
	
	/*  a placer dans le else de la condition if post  */
	public function ifNonPost($lienRand)
	{

		$image = imagecreate(120,120);
		$orange = imagecolorallocate($image, 255, 128, 0);
		$noir = imagecolorallocate($image, 255, 255, 255);
		$font = $_SERVER['DOCUMENT_ROOT']."/polices/ballpark.ttf";
		$tableau = array (1,2,3,4,5,6,7,8,9,0,'','','','','','');
		shuffle($tableau);
		$_SESSION["tableau"] = $tableau;
		imagettftext($image, 16, 0, 9, 22, $noir, $font, $tableau[0]);
		imagettftext($image, 16, 0, 9, 52, $noir, $font, $tableau[1]);
		imagettftext($image, 16, 0, 9, 82, $noir, $font, $tableau[2]);
		imagettftext($image, 16, 0, 9, 112, $noir, $font, $tableau[3]);
		imagettftext($image, 16, 0, 39, 22, $noir, $font, $tableau[4]);
		imagettftext($image, 16, 0, 39, 52, $noir, $font, $tableau[5]);
		imagettftext($image, 16, 0, 39, 82, $noir, $font, $tableau[6]);
		imagettftext($image, 16, 0, 39, 112, $noir, $font, $tableau[7]);
		imagettftext($image, 16, 0, 69, 22, $noir, $font, $tableau[8]);
		imagettftext($image, 16, 0, 69, 52, $noir, $font, $tableau[9]);
		imagettftext($image, 16, 0, 69, 82, $noir, $font, $tableau[10]);
		imagettftext($image, 16, 0, 69, 112, $noir, $font, $tableau[11]);
		imagettftext($image, 16, 0, 99, 22, $noir, $font, $tableau[12]);
		imagettftext($image, 16, 0, 99, 52, $noir, $font, $tableau[13]);
		imagettftext($image, 16, 0, 99, 82, $noir, $font, $tableau[14]);
		imagettftext($image, 16, 0, 99, 112, $noir, $font, $tableau[15]);
		imageline ($image, 0, 30, 120, 30, $noir);
		imageline ($image, 0, 60, 120, 60, $noir);
		imageline ($image, 0, 90, 120, 90, $noir);
		imageline ($image, 30, 0, 30, 120, $noir);
		imageline ($image, 60, 0, 60, 120, $noir);
		imageline ($image, 90, 0, 90, 120, $noir);
		$lien = $_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png" ;
		imagepng($image, $lien );
		imagedestroy($image);
		
	}
	
	
	public function myMap ()
	{
		$map ="" ;
		$map .="<map name=\"map\" id=\"map\">" ;
		$map .="<area shape=\"rect\" coords=\"0,0,30,30\" href=\"#\" onclick=\"javascript : bloc ('A')\" />";
		$map .="<area shape=\"rect\" coords=\"0,30,30,60\" href=\"#\" onclick=\"javascript : bloc ('B')\" />";
		$map .="<area shape=\"rect\" coords=\"0,60,30,90\" href=\"#\" onclick=\"javascript : bloc ('C')\" />";
		$map .="<area shape=\"rect\" coords=\"0,90,30,120\" href=\"#\" onclick=\"javascript : bloc ('D')\" />";
		$map .="<area shape=\"rect\" coords=\"30,0,60,30\" href=\"#\" onclick=\"javascript : bloc ('E')\" />";
		$map .="<area shape=\"rect\" coords=\"30,30,60,60\" href=\"#\" onclick=\"javascript : bloc ('F')\" />";
		$map .="<area shape=\"rect\" coords=\"30,60,60,90\" href=\"#\" onclick=\"javascript : bloc ('G')\" />";
		$map .="<area shape=\"rect\" coords=\"30,90,60,120\" href=\"#\" onclick=\"javascript : bloc ('H')\" />";
		$map .="<area shape=\"rect\" coords=\"60,0,90,30\" href=\"#\" onclick=\"javascript : bloc ('I')\" />";
		$map .="<area shape=\"rect\" coords=\"60,30,90,60\" href=\"#\" onclick=\"javascript : bloc ('J')\" />";
		$map .="<area shape=\"rect\" coords=\"60,60,90,90\" href=\"#\" onclick=\"javascript : bloc ('K')\" />";
		$map .="<area shape=\"rect\" coords=\"60,90,90,120\" href=\"#\" onclick=\"javascript : bloc ('L')\" />";
		$map .="<area shape=\"rect\" coords=\"90,0,120,30\" href=\"#\" onclick=\"javascript : bloc ('M')\" />";
		$map .="<area shape=\"rect\" coords=\"90,30,120,60\" href=\"#\" onclick=\"javascript : bloc ('N')\" />";
		$map .="<area shape=\"rect\" coords=\"90,60,120,90\" href=\"#\" onclick=\"javascript : bloc ('O')\" />";
		$map .="<area shape=\"rect\" coords=\"90,90,120,120\" href=\"#\" onclick=\"javascript : bloc ('P')\" />";
		$map .="</map>";
		
		return $map ;
		
	}
	
	
}