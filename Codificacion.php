<?php
        
//Vector inicial, de ejemplo tomamos lo que vimos en clase
$vectorBits = [0,1,0,0,1,1,1,0];

function b8zs($vector)
{
	$ret = [];
	
	//...
	
	return $ret;
}

function dbz3($vector)
{
	$ret = [];
	
	//...
	
	return $ret;
}

function ami($vector)
{
    $signalChange = false;
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

//print_r(AMI($vectorBits)); //este dump sirve para depurar el metodo de codificacion seleccionado

//pintar el vector codificado
echo RenderVector(ami($vectorBits));