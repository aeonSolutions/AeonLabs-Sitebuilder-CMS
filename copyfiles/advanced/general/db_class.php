<?php
// classe com funcoes de gestao de liga&ccedil;ao a base de dados
class database_class{

	var $host;     // host
	var $user;     // utilizador de acesso
	var $password; // password de acesso a base de dados
	var $name;     // nome da base de dados
	var $type;

	function connect(){
		$link = mysql_connect($this->host, $this->user, $this->password)
        or 
		  die('<font style="font-family:Georgia, Times, serif; font-size:10px; color:#FF0000">N&atilde;o foi possível efectuar a liga&ccedil;&atilde;o à Base de dados!! (DBClass 14) - [<strong>'.$_SERVER['SCRIPT_NAME'].'</strong>]</font>');
  		mysql_select_db($this->name)
    	or 
		  die('<font style="font-family:Georgia, Times, serif; font-size:10px; color:#FF0000">N&atilde;o foi possível efectuar a liga&ccedil;&atilde;o à Tabela!! (DBClass 17) - [<strong>'.$_SERVER['SCRIPT_NAME'].'</strong>]</font>');
		return $link;
	}

	function GetQuery($sql){
			$link=$this->connect();
			$result = mysql_query($sql);
			if (!$result){
				echo "Erro MySQL em GetQuery: ".mysql_error()."<br>";
			}			                    
			$i=0;
			$tmp[0][0]='';
			while($myrow=mysql_fetch_row($result)){
				$tmp[$i]=$myrow;
				$i++;
			}
			if (mysql_error()){
				echo "Erro MySQL em GetQuery: ".mysql_error()."<br>";
			}
			if (mysql_free_result($result)<>true){
				echo '<font style="font-family:Georgia, Times, serif; font-size:10px; color:#FF0000">Erro na query efectuada à base de dados!!!<br>';
				echo $sql.'</font><br>';
			}
			if (mysql_close($link)<>true){
				echo '<font style="font-family:Georgia, Times, serif; font-size:10px; color:#FF0000">Erro ao Fechar a conex&atilde;o com o MySQL!!!</font><br>';
			}
			return $tmp;
	}

	function SetQuery($sql){
			$link=$this->connect();
			$result = mysql_query($sql);                     
			if (mysql_error()){
				echo "Erro MySQL em SetQuery: ".mysql_error()."<br>";
			}
			if (mysql_close($link)<>true){
				echo "erro ao Fechar a conex&atilde;o com o MySQL!!!<br>";
			}
	}
	function prepare_query($string){
			$link=$this->connect();
			if(get_magic_quotes_gpc()):
                $string = stripslashes($string); 
             endif;
          	$string=mysql_real_escape_string($string); 
			if (mysql_close($link)<>true):
				echo "erro ao Fechar a conex&atilde;o com o MySQL!!!<br>";
			endif;
			return $string;
	}
};
?>
