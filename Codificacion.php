<?php

function b8zs($vector, $logicaPositiva)
{
	$ret = []; //retorno
	
	//vector de busqueda
	$secuenciaBuscar = [0,0,0,0,0,0,0,0];
	
	//Vector de reemplazo cuando el bit anterior es positivo
	$secuenciaPositiva = [0,0,0,1,-1,0,-1,1];
	
	//Vector de reemplazo cuando el bit anterior es negativo
	$secuenciaNegativa = [0,0,0,-1,1,0,1,-1];
	
	//dividir el vector segun la secuencia de 8 ceros junto a sus sobrantes
	$vectorCoincidencias = DividirVector($secuenciaBuscar, $vector);

	//determina los cambios de señal hechos por ami
	$cambioSenal = !$logicaPositiva;
	
	foreach($vectorCoincidencias as $vectorOperar)
	{
		//indice inicial para hacer el slice del vector original
		$min = $vectorOperar[0];
		
		//total de elementos a tomar para hacer el slice
		$conteo = count($vectorOperar);
		
		//basado en los limites detectados, hacer el slice
		$vectorDividido = array_slice($vector, $min, $conteo);
		
		//determinar cual es el metodo que aplica para resolver la secuencia
		$metodoResolucion = DetectarMetodoResolucion($vectorDividido, "b8zs");
		
		switch($metodoResolucion)
		{
			case "ami":
				$ret[] = ami($vectorDividido, $cambioSenal);
				break;
			case "b8zs":
				//hacer los reemplazos de la secuencia dependiendo del signo anterior
				$ret[] = $cambioSenal == true ? $secuenciaPositiva : $secuenciaNegativa;
				break;
		}
	}
	
	//como el resultado es un vector, usamos el operador ... para concatenar todos los vectores internos
	return array_merge(...$ret);
}

//determinar cual el es metodo de resolucion que aplica para el vector en cuestion
function DetectarMetodoResolucion($vectorRev, $metodoVerificar)
{
	//buscar los elementos unicos del vector, si el conteo de ese vector es 1 quiere decir
	//que solo tiene 1 elemento igual en todas sus posiciones, adicional si preguntamos que
	//elemento hay en la posicion [0] determinamos que metodo usar
	return ((count(array_unique($vectorRev)) == 1) && $vectorRev[0] == 0) ? $metodoVerificar : "ami";
}

//Divide un vector basado en otro vector, incluyendo sus sobrantes.
//este método sirve para implementacion tanto en dbz3 como b8zs
function DividirVector($secuencia, $vectorBuscar)
{
	$total = count($secuencia);
	$atotal = count($vectorBuscar);

	$i = 0;
	$k = 0;

	$ret = [];
  
	while($i < $atotal)
	{
		if(!isset($ret[$k])) $ret[$k] = [];

		if ($secuencia == array_slice($vectorBuscar,$i,$total))
		{
			$k++;

			for($o = 0; $o < $total; $o++)
			{
				$ret[$k][] = $i;
				$i++;
			}

			$k++;
		}
		else
		{
			$ret[$k][]  = $i;    
			$i++;
		}
	}
	
	return $ret;
}


function hdb3($vector)
{
	$ret = [];
	
	//...
	
	return $ret;
}

//$vector es el vector de bits
//&$signalChange es un bool pasado por referencia que indica si inicio con cambio de señal
function ami($vector, &$signalChange)
{
    $bitAux = null;
    $ret = [];
    
	//recorrer todo el vector
    foreach($vector as $bit)
    {
        if($bit == 1)
        {
			//colocar 1 o -1 dependiendo del cambio de señal
            $bitAux = $signalChange ? -1 : 1;
			
			//cambiar señal
            $signalChange = !$signalChange;
        }
        else
        {
            $bitAux = 0;
        }
        
		//adicionar item al vector
        array_push($ret, $bitAux);
    }
    
    return $ret;
}
//PILAS! no modifiquen este algoritmo, funciona para cualquier tipo de codificacion
function RenderVector($vector)
{
    $s1 = "";
    $s2 = "";
    $header = "";
    foreach($vector as $bit)
    {
        $header .= "<th>$bit</th>";
        $s1 .= "<td ".(($bit == 1) ? "class='up'" : "").">-</td>";
        $s2 .= "<td ".(($bit == -1) ? "class='dw'" : "").">-</td>";
    }
    
    return "<table cellspacing='0'><tr class='head'>$header</tr><tr class='ld'>$s1</tr><tr class='lu'>$s2</tr></table>";
}

/*Codigo para probar ami*/
//$vectorBits = [0,1,0,0,1,1,1,0];
//$signalChange = false;
//echo RenderVector(ami($vectorBits));


/*Codigo para probar b8zs*/
//$vectorBits = [1,0,0,0,0,0,0,0,0,1,1];
//echo RenderVector(b8zs($vectorBits, true)); //logica positiva

//$vectorBits = [1,1,1,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0];
//echo RenderVector(b8zs($vectorBits, false)); //logica negativa

/*codigo para probar dbz3*/