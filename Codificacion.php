<?php
        
//Vector inicial, de ejemplo tomamos lo que vimos en clase
$vectorBits = [0,1,0,0,1,1,1,0]; //ejercicio para ami

$vectorBits_b8zs = [1,1,1,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0]; //ejercicio b8zs

function b8zs($vector)
{
	$ret = []; //retorno
	
	//vector de busqueda
	$secuenciaBuscar = [0,0,0,0,0,0,0,0];
	
	//Vector de reemplazo cuando el bit anterior es positivo
	$secuenciaPositiva = [0,0,0,1,-1,0,-1,1];
	
	//Vector de reemplazo cuando el bit anterior es negativo
	$secuenciaNegativa = [0,0,0,-1,1,0,1,-1];
	
	$vectorFiltro = BuscarEnVector($secuenciaBuscar, $vector);
	
	print_r($vectorFiltro);
	
	foreach($vectorFiltro as $i => $valor)
	{
		$minBound = $valor[0];
		$maxBound = $valor[count($valor) - 1];
		
		echo "Min: $minBound / Max: $maxBound\n";
	}
	
	return $ret;
}

//Busca dentro de un vector otro vector para determinar sus indices
//la idea es hacer un split pero en vez de buscar un caracter en especifico
//se usa otro vector para hacer el split
function BuscarEnVector($vectorBuscar, $vector) 
{
    $listaIndices = array_keys($vector, $vectorBuscar[0]);
    $ret = [];
	
    foreach ($listaIndices as $indice) 
	{
        $adicionar = true;
        $resultado = [];
        
		foreach ($vectorBuscar as $i => $valor) 
		{
            if (!(isset($vector[$indice + $i]) && $vector[$indice + $i] == $valor)) 
			{
                $adicionar = false;
                break;
            }
			
            $resultado[] = $indice + $i;
        }
		
        if ($adicionar == true) 
		{ 
            $ret[] = $resultado;
        }
    }
	
    return $ret;
}



function dbz3($vector)
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
    
    foreach($vector as $bit)
    {
        if($bit == 1)
        {
            $bitAux = $signalChange ? -1 : 1;
            $signalChange = !$signalChange;
        }
        else
        {
            $bitAux = 0;
        }
        
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

/*Codigo para probar AMI*/
//$signalChange = false;
//$vec = ami($vectorBits, $signalChange);
//print_r(ami($vectorBits, $signalChange)); //este dump sirve para depurar el metodo de codificacion seleccionado

//codigo para probar b8zs
$vec = b8zs($vectorBits_b8zs);


//pintar el vector codificado
//echo RenderVector(ami($vectorBits));