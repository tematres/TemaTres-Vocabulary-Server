<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Columnas múltiples</title>
<link type="text/css" rel="stylesheet" href="../fpdf.css">
</head>
<body>
<h1>Columnas múltiples</h1>
Este ejemplo es una variante del anterior en el que se mostrará como disponer texto
en varias columnas.
<div class="source">
<pre><code>&lt;?php
<span class="kw">require(</span><span class="str">'fpdf.php'</span><span class="kw">);

class </span>PDF <span class="kw">extends </span>FPDF
<span class="kw">{
protected </span>$col <span class="kw">= </span>0<span class="kw">; </span><span class="cmt">// Columna actual
</span><span class="kw">protected </span>$y0<span class="kw">;      </span><span class="cmt">// Ordenada de comienzo de la columna

</span><span class="kw">function </span>Header<span class="kw">()
{
    </span><span class="cmt">// Cabacera
    </span><span class="kw">global </span>$title<span class="kw">;

    </span>$<span class="kw">this-&gt;</span>SetFont<span class="kw">(</span><span class="str">'Arial'</span><span class="kw">,</span><span class="str">'B'</span><span class="kw">,</span>15<span class="kw">);
    </span>$w <span class="kw">= </span>$<span class="kw">this-&gt;</span>GetStringWidth<span class="kw">(</span>$title<span class="kw">)+</span>6<span class="kw">;
    </span>$<span class="kw">this-&gt;</span>SetX<span class="kw">((</span>210<span class="kw">-</span>$w<span class="kw">)/</span>2<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetDrawColor<span class="kw">(</span>0<span class="kw">,</span>80<span class="kw">,</span>180<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetFillColor<span class="kw">(</span>230<span class="kw">,</span>230<span class="kw">,</span>0<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetTextColor<span class="kw">(</span>220<span class="kw">,</span>50<span class="kw">,</span>50<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetLineWidth<span class="kw">(</span>1<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Cell<span class="kw">(</span>$w<span class="kw">,</span>9<span class="kw">,</span>$title<span class="kw">,</span>1<span class="kw">,</span>1<span class="kw">,</span><span class="str">'C'</span><span class="kw">,</span>true<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Ln<span class="kw">(</span>10<span class="kw">);
    </span><span class="cmt">// Guardar ordenada
    </span>$<span class="kw">this-&gt;</span>y0 <span class="kw">= </span>$<span class="kw">this-&gt;</span>GetY<span class="kw">();
}

function </span>Footer<span class="kw">()
{
    </span><span class="cmt">// Pie de página
    </span>$<span class="kw">this-&gt;</span>SetY<span class="kw">(-</span>15<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetFont<span class="kw">(</span><span class="str">'Arial'</span><span class="kw">,</span><span class="str">'I'</span><span class="kw">,</span>8<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetTextColor<span class="kw">(</span>128<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Cell<span class="kw">(</span>0<span class="kw">,</span>10<span class="kw">,</span><span class="str">'Página '</span><span class="kw">.</span>$<span class="kw">this-&gt;</span>PageNo<span class="kw">(),</span>0<span class="kw">,</span>0<span class="kw">,</span><span class="str">'C'</span><span class="kw">);
}

function </span>SetCol<span class="kw">(</span>$col<span class="kw">)
{
    </span><span class="cmt">// Establecer la posición de una columna dada
    </span>$<span class="kw">this-&gt;</span>col <span class="kw">= </span>$col<span class="kw">;
    </span>$x <span class="kw">= </span>10<span class="kw">+</span>$col<span class="kw">*</span>65<span class="kw">;
    </span>$<span class="kw">this-&gt;</span>SetLeftMargin<span class="kw">(</span>$x<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetX<span class="kw">(</span>$x<span class="kw">);
}

function </span>AcceptPageBreak<span class="kw">()
{
    </span><span class="cmt">// Método que acepta o no el salto automático de página
    </span><span class="kw">if(</span>$<span class="kw">this-&gt;</span>col<span class="kw">&lt;</span>2<span class="kw">)
    {
        </span><span class="cmt">// Ir a la siguiente columna
        </span>$<span class="kw">this-&gt;</span>SetCol<span class="kw">(</span>$<span class="kw">this-&gt;</span>col<span class="kw">+</span>1<span class="kw">);
        </span><span class="cmt">// Establecer la ordenada al principio
        </span>$<span class="kw">this-&gt;</span>SetY<span class="kw">(</span>$<span class="kw">this-&gt;</span>y0<span class="kw">);
        </span><span class="cmt">// Seguir en esta página
        </span><span class="kw">return </span>false<span class="kw">;
    }
    else
    {
        </span><span class="cmt">// Volver a la primera columna
        </span>$<span class="kw">this-&gt;</span>SetCol<span class="kw">(</span>0<span class="kw">);
        </span><span class="cmt">// Salto de página
        </span><span class="kw">return </span>true<span class="kw">;
    }
}

function </span>ChapterTitle<span class="kw">(</span>$num<span class="kw">, </span>$label<span class="kw">)
{
    </span><span class="cmt">// Título
    </span>$<span class="kw">this-&gt;</span>SetFont<span class="kw">(</span><span class="str">'Arial'</span><span class="kw">,</span><span class="str">''</span><span class="kw">,</span>12<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>SetFillColor<span class="kw">(</span>200<span class="kw">,</span>220<span class="kw">,</span>255<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Cell<span class="kw">(</span>0<span class="kw">,</span>6<span class="kw">,</span><span class="str">"Capítulo </span>$num<span class="str"> : </span>$label<span class="str">"</span><span class="kw">,</span>0<span class="kw">,</span>1<span class="kw">,</span><span class="str">'L'</span><span class="kw">,</span>true<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Ln<span class="kw">(</span>4<span class="kw">);
    </span><span class="cmt">// Guardar ordenada
    </span>$<span class="kw">this-&gt;</span>y0 <span class="kw">= </span>$<span class="kw">this-&gt;</span>GetY<span class="kw">();
}

function </span>ChapterBody<span class="kw">(</span>$file<span class="kw">)
{
    </span><span class="cmt">// Abrir fichero de texto
    </span>$txt <span class="kw">= </span>file_get_contents<span class="kw">(</span>$file<span class="kw">);
    </span><span class="cmt">// Fuente
    </span>$<span class="kw">this-&gt;</span>SetFont<span class="kw">(</span><span class="str">'Times'</span><span class="kw">,</span><span class="str">''</span><span class="kw">,</span>12<span class="kw">);
    </span><span class="cmt">// Imprimir texto en una columna de 6 cm de ancho
    </span>$<span class="kw">this-&gt;</span>MultiCell<span class="kw">(</span>60<span class="kw">,</span>5<span class="kw">,</span>$txt<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Ln<span class="kw">();
    </span><span class="cmt">// Cita en itálica
    </span>$<span class="kw">this-&gt;</span>SetFont<span class="kw">(</span><span class="str">''</span><span class="kw">,</span><span class="str">'I'</span><span class="kw">);
    </span>$<span class="kw">this-&gt;</span>Cell<span class="kw">(</span>0<span class="kw">,</span>5<span class="kw">,</span><span class="str">'(fin del extracto)'</span><span class="kw">);
    </span><span class="cmt">// Volver a la primera columna
    </span>$<span class="kw">this-&gt;</span>SetCol<span class="kw">(</span>0<span class="kw">);
}

function </span>PrintChapter<span class="kw">(</span>$num<span class="kw">, </span>$title<span class="kw">, </span>$file<span class="kw">)
{
    </span><span class="cmt">// Añadir capítulo
    </span>$<span class="kw">this-&gt;</span>AddPage<span class="kw">();
    </span>$<span class="kw">this-&gt;</span>ChapterTitle<span class="kw">(</span>$num<span class="kw">,</span>$title<span class="kw">);
    </span>$<span class="kw">this-&gt;</span>ChapterBody<span class="kw">(</span>$file<span class="kw">);
}
}

</span>$pdf <span class="kw">= new </span>PDF<span class="kw">();
</span>$title <span class="kw">= </span><span class="str">'20000 Leguas de Viaje Submarino'</span><span class="kw">;
</span>$pdf<span class="kw">-&gt;</span>SetTitle<span class="kw">(</span>$title<span class="kw">);
</span>$pdf<span class="kw">-&gt;</span>SetAuthor<span class="kw">(</span><span class="str">'Julio Verne'</span><span class="kw">);
</span>$pdf<span class="kw">-&gt;</span>PrintChapter<span class="kw">(</span>1<span class="kw">,</span><span class="str">'UN RIZO DE HUIDA'</span><span class="kw">,</span><span class="str">'20k_c1.txt'</span><span class="kw">);
</span>$pdf<span class="kw">-&gt;</span>PrintChapter<span class="kw">(</span>2<span class="kw">,</span><span class="str">'LOS PROS Y LOS CONTRAS'</span><span class="kw">,</span><span class="str">'20k_c2.txt'</span><span class="kw">);
</span>$pdf<span class="kw">-&gt;</span>Output<span class="kw">();
</span>?&gt;</code></pre>
</div>
<p class='demo'><a href='tuto4.php' target='_blank' class='demo'>[Ejecutar]</a></p>
El método clave usado es <a href='../doc/acceptpagebreak.htm'>AcceptPageBreak()</a>. Permite aceptar o no el salto
automático de línea. Evitándolo y alterando la posición actual y el margen,
se consigue la disposición deseada en columnas.
<br>
Por lo demás, poco cambia; se han añadido dos propiedades (atributos) a la clase
para almacenar el número de columna y la posición donde empiezan las columnas, y
la llamada a MultiCell() incluye un ancho de 6 centímetros.
</body>
</html>
