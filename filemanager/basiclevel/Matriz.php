<?
/*$dados = array(array("1","2","3"),"joao",array(4,5));
print( Matriz::desenha( $dados ) ."-");
print( Matriz::desenha( Matriz::devolveTransposta($dados) ) ."-");
print( Matriz::desenha( Matriz::ordenaCrescentemente($dados,3) ) ."-");
print( Matriz::desenha( Matriz::ordenaDescrescentemente($dados,3) ) ."-");*/

class Matriz
{
	function devolveOMaiorTamanhoDeLinha($matriz)
	{
		$tamanho_maior = 0;
		for($i = 0; $i < count($matriz); ++$i):
			if($tamanho_maior < count($matriz[$i])):
			 	$tamanho_maior = count($matriz[$i]);
			endif;
		endfor;
		return $tamanho_maior;
	}
	
	function devolveTranspostaComplexa($matriz,$nivel_de_sub_matrizes)//fazer uma nova transposta com niveis de recursividade infinitos, como o procedimento "junta"
	{
		$tamanho_maior = Matriz::devolveOMaiorTamanhoDeLinha($matriz);
		if($nivel_de_sub_matrizes > 0):
			for($i = 0; $i < count($matriz); ++$i):
				$linha = $matriz[$i];
				$linha = Matriz::devolveTranspostaComplexa($linha,$nivel_de_sub_matrizes-1);
				$matriz[$i] = $linha;
			endfor;
		endif;

		for($i = 0; $i < count($matriz); ++$i):
			$linha = $matriz[$i];
			if(!is_array($linha)):
				$linha = array($linha);
			endif;
			for($j = 0; $j < $tamanho_maior; ++$j):
				$transposta[$j][$i] = $linha[$j];
			endfor;
		endfor;

		return $transposta;
	}
	
	function devolveTransposta($matriz)
	{
		return Matriz::devolveTranspostaComplexa($matriz,0);
		/*
		$tamanho_maior = Matriz::devolveOMaiorTamanhoDeLinha($matriz);
		for($i = 0; $i < count($matriz); ++$i)
		{
			$linha = $matriz[$i];
			if(!is_array($linha))
				$linha = array($linha);
			
			for($j = 0; $j < $tamanho_maior; ++$j)
				$transposta[$j][$i] = $linha[$j];
		}
		return $transposta;
		*/
	}
	
	function ordenaCrescentemente($matriz,$coluna)
	{
		$transposta = Matriz::devolveTransposta($matriz);
		$tamanho_maior = Matriz::devolveOMaiorTamanhoDeLinha($transposta);
		$coluna_para_ordenar = $transposta[$coluna-1];

		if($coluna > 0 && is_array($coluna_para_ordenar))
			if(asort($coluna_para_ordenar))									// aMen now sorted; numeric keys out of order 
			{
				$indices = array_keys($coluna_para_ordenar);				// create a new array for result 
				for($i = 0; $i < count($transposta); ++$i)
				{
					$coluna_transposta = $transposta[$i];
					for($j = 0; $j < $tamanho_maior; ++$j)
						$transposta[$i][$j] = $coluna_transposta[$indices[$j]];
				}
				$matriz = Matriz::devolveTransposta($transposta);
			}
		
		return array($matriz,$indices);
	}
	
	function ordenaDescrescentemente($matriz,$coluna)
	{
		$transposta = Matriz::devolveTransposta($matriz);
		$tamanho_maior = Matriz::devolveOMaiorTamanhoDeLinha($transposta);
		$coluna_para_ordenar = $transposta[$coluna-1];
		
		if($coluna > 0 && is_array($coluna_para_ordenar))
			if(asort($coluna_para_ordenar))									// aMen now sorted; numeric keys out of order 
			{
				$indices = array_keys($coluna_para_ordenar);				// create a new array for result 
				for($i = 0; $i < count($transposta); ++$i)
				{
					$coluna_transposta = $transposta[$i];
					for($j = 0; $j < $tamanho_maior; ++$j)
					{
						$indice = count($coluna_transposta)-$j-1;
						$transposta[$i][$j] = $coluna_transposta[$indices[$indice]];
					}
				}
				$matriz = Matriz::devolveTransposta($transposta);
			}
		if(is_array($indices))
			$indices = array_reverse($indices);
		return array($matriz,$indices);
	}
	
	function desenha($matriz)
	{
		if(is_array($matriz[0]))
			for($i = 0; $i < count($matriz); ++$i)
			{
				$html .= "<p>&nbsp;|&nbsp;";
				$linha = $matriz[$i];
				for($j = 0; $j < count($linha); ++$j)
					$html .= Matriz::desenha($linha[$j])."&nbsp;|&nbsp;";
				$html .= "</p>";
			}
		else
		{
			$html .= "<p>&nbsp;|&nbsp;";			
			for($i = 0; $i < count($matriz); ++$i)
				$html .= $matriz[$i]."&nbsp;|&nbsp;";
			$html .= "<p>";
		}
		return $html;
	}
	
	function removeColuna($matriz,$num_coluna)
	{
		--$num_coluna;
		if(is_array($matriz))
			for($i = 0; $i < count($matriz); ++$i)
			{
				$linha = $matriz[$i];
				for($j = $num_coluna+1; $j < count($linha); ++$j)
					$linha[$j-1] = $matriz[$i][$j];
				array_pop($linha);
				$matriz[$i] = $linha;
			}
		return $matriz;
	}
	
	function removeLinha($matriz,$num_linha)
	{
		--$num_linha;
		if(is_array($matriz))
		{
			for($i = $num_linha+1; $i < count($matriz); ++$i)
				$matriz[$i-1] = $matriz[$i];
		
			array_pop($matriz);
		}
		return $matriz;
	}
	
	function juntaComplexo($array_de_matrizes,$nivel_de_sub_matrizes)
	{
		$matriz_unida = $array_de_matrizes[0];

		if($nivel_de_sub_matrizes > 0)
			for($i = 0; $i < count($matriz_unida); ++$i)
			{
				$linha = $matriz_unida[$i];
				for($j = 1; $j < count($array_de_matrizes); ++$j)
				{
					$linha_j = $array_de_matrizes[$j][$i];
					$linha = Matriz::juntaComplexo(array($linha,$linha_j),$nivel_de_sub_matrizes-1);
				}
				$matriz_unida[$i] = $linha;
			}
		else
			for($i = 1; $i < count($array_de_matrizes); ++$i)
			{
				$matriz = $array_de_matrizes[$i];
				$matriz_unida = array_merge($matriz_unida,$matriz);
			}
		return $matriz_unida;
	}
	
	function juntaMatrizesSimples($array_de_matrizes)
		{return Matriz::juntaComplexo($array_de_matrizes,0);}
		
	function juntaMatrizesComSubMatrizes($array_de_matrizes)
		{return Matriz::juntaComplexo($array_de_matrizes,1);}
		
	function removeDuplicadosComplexo($matriz,$coluna)
	{
		if(is_array($matriz[0]) && $coluna > 0)
		{
			$transposta = Matriz::devolveTransposta($matriz);
			$matriz_coluna = $transposta[$coluna-1];
			for($i = 0; $i < count($matriz_coluna); ++$i)
				for($j = $i+1; $j < count($matriz_coluna); ++$j)
					if($matriz_coluna[$i] == $matriz_coluna[$j])
					{
						$matriz_coluna = Matriz::removeLinha($matriz_coluna,$j);
						$matriz = Matriz::removeLinha($matriz,$j);
						--$j;
					}
		}
		return $matriz;
	}
	
	function removeDuplicadosSimples($matriz)
	{
		for($i = 0; $i < count($matriz); ++$i)
			for($j = $i+1; $j < count($matriz); ++$j)
				if($matriz[$i] == $matriz[$j])
				{
					$matriz = Matriz::removeLinha($matriz,$j);
					--$j;
				}
		return $matriz;
	}
	
	function retificaArray($array)
	{
		$array_correcto = array();
		for($i = 0; $i < count($array); ++$i)
			//if(!empty($array[$i]) && is_string($array[$i]) && $array[$i] != false)
			if($array[$i] != false)
				$array_correcto[count($array_correcto)] = $array[$i];
		return $array_correcto;
	}
}
?>