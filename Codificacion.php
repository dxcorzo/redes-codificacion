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
	$totalUnosTransmitidos = 0;
	
	foreach($vectorCoincidencias as $vectorOperar)
	{
		//determinar cual es el metodo que aplica para resolver la secuencia
		$metodoResolucion = DetectarMetodoResolucion($vectorOperar, "b8zs");
		
		switch($metodoResolucion)
		{
			case "ami":
				$ret[] = ami($vectorOperar, $cambioSenal, $totalUnosTransmitidos);
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

function hdb3($vector)
{
	$ret = []; //retorno
	
	//vector de busqueda
	$secuenciaBuscar = [0,0,0,0];
	
	//vectores de reemplazo (reglas)
	$secuenciaPositiva_Par = [-1,0,0,-1];
	$secuenciaNegativa_Par = [1,0,0,1];
	$secuenciaPositiva_Impar = [0,0,0,1];
	$secuenciaNegativa_Impar = [0,0,0,-1];
	
	//dividir el vector segun la secuencia de 4 ceros junto a sus sobrantes
	$vectorCoincidencias = DividirVector($secuenciaBuscar, $vector);

	//determina los cambios de señal hechos por ami
	$cambioSenal = false;
	$totalUnosTransmitidos = 0;
	
	foreach($vectorCoincidencias as $vectorOperar)
	{
		//determinar cual es el metodo que aplica para resolver la secuencia
		$metodoResolucion = DetectarMetodoResolucion($vectorOperar, "hdb3");
		
		switch($metodoResolucion)
		{
			case "ami":
				$ret[] = ami($vectorOperar, $cambioSenal, $totalUnosTransmitidos);
				$cambioSenal = !$cambioSenal;
				break;
			case "hdb3":
				if($totalUnosTransmitidos % 2 == 0) //Si es par
				{
					$ret[] = $cambioSenal ? $secuenciaNegativa_Par : $secuenciaPositiva_Par;
					$totalUnosTransmitidos = $totalUnosTransmitidos + 2;
				}
				else //es impar
				{
					$ret[] = $cambioSenal ? $secuenciaNegativa_Impar : $secuenciaPositiva_Impar;
					$totalUnosTransmitidos++;
				}
				
				break;
		}
	}
	
	//como el resultado es un vector, usamos el operador ... para concatenar todos los vectores internos
	return array_merge(...$ret);
}

//$vector es el vector de bits
//&$signalChange es un bool pasado por referencia que indica si inicio con cambio de señal
function ami($vector, &$signalChange, &$totalUnosTransmitidos)
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
			
			//sumar el # de 1 transmitidos independiente si es positivo o negativo
			//luego lo usaremos para determinar si es par o impar
			$totalUnosTransmitidos++;
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


//determinar cual el es metodo de resolucion que aplica para el vector en cuestion
function DetectarMetodoResolucion($vectorRev, $metodoVerificar)
{
	//buscar los elementos unicos del vector, si el conteo de ese vector es 1 quiere decir
	//que solo tiene 1 elemento igual en todas sus posiciones, adicional si preguntamos que
	//elemento hay en la posicion [0] determinamos que metodo usar
	return ((count($vectorRev) == 4 || count($vectorRev) == 8) && (count(array_unique($vectorRev)) == 1) && $vectorRev[0] == 0) ? $metodoVerificar : "ami";
}

//Divide un vector basado en otro vector, incluyendo sus sobrantes.
//este método sirve para implementacion tanto en hdb3 como b8zs
function DividirVector($patron, $vectorBuscar)
{
	//convertir ambos vectores a strings para poder manipularlos mediante expresiones regulares
    $patron2 = implode("", $patron);
    $vectorBuscar2  = implode("", $vectorBuscar);

	//añadimos comas antes y despues de la cadena a buscar
    $vectorBuscar2  = preg_replace("/" . $patron2 . "/", "," . $patron2 . ",", $vectorBuscar2);

    //usando las comas, puedo armar un vector haciendo un split, ahi tengo tanto las coincidencias como los sobrantes
    $vectorBuscar2  = preg_split("/,/", $vectorBuscar2, 0, PREG_SPLIT_NO_EMPTY);

    //convertir los chars de las cadenas internas en vectores
    for($x = 0; $x < count($vectorBuscar2); $x++) 
	{
        $vectorBuscar2[$x] = str_split($vectorBuscar2[$x]);
    }

    //devuelve el vector con los vectores internos
    return $vectorBuscar2;
}

function RenderVector($base, $vector)
{
    $s1 = "";
    $s2 = "";
    $header = "";
	
    foreach($vector as $i => $bit)
    {
        $header .= "<th>".$base[$i]."</th>"; //mostrar el bit con el que se calculo el resultado		
        $s1 .= "<td ".(($bit == 1) ? "class='up'" : "").">-</td>"; //linea para los positivos
        $s2 .= "<td ".(($bit == -1) ? "class='dw'" : "").">-</td>"; //linea para los negativos
    }
    
    return "<table cellspacing='0'><tr class='head'>$header</tr><tr class='ld'>$s1</tr><tr class='lu'>$s2</tr></table>";
}

/*Codigo para probar ami*/
//$vectorBits = [0,1,0,0,1,1,1,0];
//$signalChange = false;
//echo RenderVector($vectorBits, ami($vectorBits));


/*Codigo para probar b8zs*/
//$vectorBits = [1,0,0,0,0,0,0,0,0,1,1];
//echo RenderVector($vectorBits, b8zs($vectorBits, true)); //logica positiva

//$vectorBits = [1,1,1,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0];
//echo RenderVector($vectorBits, b8zs($vectorBits, false)); //logica negativa

/*codigo para probar hdb3*/
//$vectorBits = [1,0,0,0,0,0,0,0,0,0,0,1,0,0]; //funciona ok
//$vectorBits = [1,1,0,0,0,0,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0]; //ok
//echo RenderVector($vectorBits, hdb3($vectorBits));