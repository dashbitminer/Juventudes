<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .fit-input {
            width: 100%;
            height: 100%;
            border: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box; /* Ensures padding and border are included in the element's total width and height */
        }
    </style>
</head>
<body>

    <div>
        <div style="clear:both;">
            <p style="margin-top:0pt; margin-bottom:0pt; line-height:115%; widows:0; orphans:0; font-size:2pt; margin-right: 25px">
                {{-- This is Glasswing Logo --}}
                <img src="data:image/png;base64,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" width="120" height="49" alt="" style="float: right; ">
            </p>
        </div>
        <p style="margin-top:0pt; margin-left:26pt; margin-bottom:0pt; text-indent:36pt; font-size:14pt;"><a name="_heading_h.gjdgxs"></a><strong><span style="font-family:Arial; color:#037179;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></strong>
            {{-- This is USAID Logo --}}
            <img src="data:image/png;base64,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" width="156" height="63" alt="" style="float: left; ">
            {{-- <img src="data:image/png;base64,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" width="161" height="75" alt="" style="float: left; "> --}}

        </p>
        <p style="margin-top:20pt; margin-bottom:0pt; text-align:center; font-size:14pt;"><strong><span style="font-family:Arial; color:#037179;">FICHA DE INSCRIPCI&Oacute;N&nbsp;</span></strong></p>
        <p style="margin-top:20pt; margin-bottom:0pt; text-align:center; font-size:14pt;"><strong><span style="font-family:Arial; color:#037179;">&nbsp;</span></strong></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:13pt;"><strong><span style="font-family:Arial; color:#037179;">Proyecto o programa:  <span style="text-decoration: underline; width:80%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $proyecto->nombre }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:13pt;"><strong><span style="font-family:Arial; color:#037179;">&nbsp;</span></strong></p>
        <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify;"><span style="font-family:Arial;">A continuaci&oacute;n, te presentamos un formulario de inscripci&oacute;n que debe ser llenado con lapicero sin tachaduras, solamente una vez sin importar que participes en uno o m&aacute;s talleres, formaciones, entre otros, impartidos por Glasswing. Toda la informaci&oacute;n ser&aacute; guardada con estricta confidencialidad y nada de lo que compartas tendr&aacute; repercusiones sobre tu persona.</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt;">&nbsp;</p>
        <table cellspacing="0" cellpadding="0" style="width:518.3pt; border-collapse:collapse;">
            <tbody>
                <tr style="height:18.45pt;">
                    <td colspan="27" style="width:506.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#006666;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N I: GENERALIDADES DE SOCIO</span></strong></p>
                    </td>
                </tr>
                <tr style="height:21.3pt;">
                    <td colspan="2" style="width:137.5pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:10.9pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">N&deg; de Cohorte:</li>
                        </ol>
                    </td>
                    <td colspan="7" style="width:67.15pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">{{ $cohorte->nombre }}</span></strong></p>
                    </td>
                    <td colspan="12" style="width:137.7pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="2" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; widows:0; orphans:0; padding-left:1.38pt; font-family:Arial; font-size:11pt; font-weight:bold;">Socio implementador: </li>
                        </ol>
                    </td>
                    <td colspan="6" style="width:132pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">
                            {{ $participante->gestor->socioImplementador->nombre ?? '' }}
                        </span></strong></p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="12" style="width:229.95pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="3" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Fecha del levantamiento de informaci&oacute;n:</li>
                        </ol>
                    </td>
                    <td colspan="15" style="width:266pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">
                        {{ $participante->created_at->format('d/m/Y') }}
                        </span></strong></p>
                    </td>
                </tr>
                <tr style="height:17pt;">
                    <td colspan="12" style="width:229.95pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="4" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Modalidad de programa:</li>
                        </ol>
                    </td>
                    <td colspan="15" style="width:266pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">
                            {{-- {{ $modalidad->nombre }} --}}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:0.9pt;">
                    <td colspan="27" style="width:506.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#006666;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N II: DATOS GENERALES DE PARTICIPANTE</span></strong></p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="4" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Nombres completos:</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:377.55pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        {{ $participante->nombre_completo }}
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="4" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="2" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Apellidos completos:</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:377.55pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        {{ $participante->apellido_completo }}
                    </td>
                </tr>
                <tr style="height:1pt;">
                    <td colspan="4" style="width:123.65pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="3" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Fecha de nacimiento:</li>
                        </ol>
                    </td>
                    <td colspan="8" style="width:106.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            {{ Carbon\Carbon::parse($participante->fecha_nacimiento)->format('d / m / Y') }}
                        </p>
                    </td>
                    <td colspan="9" style="width:85.15pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="4" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:12.5pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Nacionalidad:</li>
                        </ol>
                    </td>
                    <td colspan="6" style="width:159.15pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;">
                            {{ $participante->formatted_nacionalidad }}
                        </p>
                    </td>
                </tr>
                <tr style="height:1pt;">
                    <td colspan="4" style="width:88.2pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="5" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Estado civil:</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:407.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            {{ $participante->estadoCivil->nombre }}
                        </p>
                    </td>
                </tr>
                <tr style="height:1pt;">
                    <td rowspan="5" style="width:59.85pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:11.6pt; margin-bottom:0pt; text-indent:-11.6pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">&nbsp;</span></strong></p>
                        <ol start="6" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Domicilio</li>
                        </ol>
                    </td>
                    <td colspan="10" style="width:102.6pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">&iquest;En qu&eacute; tipo de zona resides?</span></strong></p>
                    </td>
                    <td colspan="16" style="width:322.7pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                           {{ $participante->formatted_tipo_zona_residencia }}
                        </p>
                    </td>
                </tr>
                <tr style="height:1pt;">
                    <td colspan="10" style="width:141.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">Departamento</span></strong></p>
                    </td>
                    <td colspan="12" style="width:131.5pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">Municipio</span></strong></p>
                    </td>
                    <td colspan="4" style="width:141.65pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">Comunidad/colonia</span></strong></p>
                    </td>
                </tr>
                <tr style="height:11.7pt;">
                    <td colspan="10" style="width:141.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                        {{ $participante->ciudad->departamento->nombre }}
                        </span></p>
                    </td>
                    <td colspan="12" style="width:131.5pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                            {{ $participante->ciudad->nombre }}
                        </span></p>
                    </td>
                    <td colspan="4" style="width:141.65pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                        {{ $participante->colonia }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:2.45pt;">
                    <td colspan="26" style="width:436.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">Direcci&oacute;n completa con puntos de referencia</span></strong></p>
                    </td>
                </tr>
                <tr style="height:19.25pt;">
                    <td colspan="26" style="width:436.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                            {{ $participante->direccion}}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:0.9pt;">
                    <td colspan="10" style="width:194.85pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="7" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">Sexo seg&uacute;n registro nacional:</li>
                        </ol>
                    </td>
                    <td colspan="17" style="width:301.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                            <span style="font-family:Arial;">{{ $participante->formatted_sexo }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="10" style="width:116.55pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="8" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;Posee alg&uacute;n tipo de discapacidad?</li>
                        </ol>
                    </td>
                    <td colspan="17" style="width:379.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            {{ $participante->discapacidades->pluck('nombre')->implode(', ') }}
                        </p>
                    </td>
                </tr>
                {{-- <tr style="height:1pt;">
                    <td colspan="10" style="width:194.85pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="9" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;A cu&aacute;l de los siguientes grupos cree que pertenece?</li>
                        </ol>
                    </td>
                    <td colspan="17" style="width:301.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">

                            @foreach ($participante->gruposPertenecientes as $item)
                                @if ($item->grupoPerteneciente->id == \App\Models\GrupoPerteneciente::OTRO)
                                Otro:
                                    {{ $item->pivot->otro_grupo }}
                                @else
                                    {{ $item->grupoPerteneciente->nombre }}
                                @endif
                            @endforeach

                        </p>
                    </td>
                </tr> --}}
                <tr style="height:1pt;">
                    <td colspan="10" style="width:180.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:11.6pt; margin-bottom:0pt; text-indent:-11.6pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">9. &iquest;A qu&eacute; pueblo ind&iacute;gena o comunidad &eacute;tnica perteneces?</span></strong></p>
                    </td>
                    <td colspan="17" style="width:315.6pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                            @if(!empty($participante->comunidadEtnica))
                                {{ $participante->comunidadEtnica->pluck('grupoEtnico.nombre')->implode(', ') }}
                            @endif
                        </span></p>
                    </td>
                </tr>
                <tr style="height:8.5pt;">
                    <td colspan="10" style="width:272.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:11.6pt; margin-bottom:0pt; text-indent:-11.6pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">10. &iquest;Con qu&eacute; comunidad ling&uuml;&iacute;stica se identifica?</span></strong></p>
                    </td>
                    <td colspan="17" style="width:223.5pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                            @if(!empty($participante->comunidadEtnica))
                                {{ $participante->comunidadEtnica->pluck('nombre')->implode(', ') }}
                            @endif
                        </span></p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="10" style="width:159.05pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="11" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18.6pt;  widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;Cu&aacute;l es tu proyecto de vida principal? Marca la opci&oacute;n que mejor describa tu objetivo:</li>
                        </ol>
                    </td>
                    <td colspan="17" style="width:336.9pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        @foreach ($participante->proyectoVida as $proyecto)
                            @if($proyecto->id == App\Models\ProyectoVida::ESPECIFICAR)
                                <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                                    {{ $proyecto->nombre.' '.$proyecto->comentario.': '.$proyecto->pivot->comentario }}
                                </span></p>
                            @else
                                <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                                    <span style="font-family:Arial;">{{ $proyecto->nombre.' '.$proyecto->comentario }}</span></p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr style="height:11.45pt;">
                    <td colspan="7" style="width:159.05pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="12" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18.6pt;  widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">¿Tienes hijos y/o hijas?</li>
                        </ol>
                    </td>
                    <td colspan="6" style="width:76.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;">
                            <span style="font-family:Arial;">
                                {{ $participante->formatted_tiene_hijos }}
                            </span>
                        </p>
                    </td>
                    <td colspan="11" style="width:192.9pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial;">12.1 &iquest;Cu&aacute;ntos hijos y/o hijas tienes?</span></strong></p>
                    </td>
                    <td  colspan="3" style="width:46.3pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">
                            {{ $participante->cantidad_hijos }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="13" style="width:222.85pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:11.6pt; margin-bottom:0pt; text-indent:-11.6pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">12.2 &iquest;Con qui&eacute;n o quienes compartes la paternidad/maternidad de tus hijos?</span></strong></p>
                    </td>
                    <td colspan="14" style="width:273.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">
                                {{ $participante->responsabilidadHijos->pluck('nombre')->implode(', ') }}
                            </span>
                        </p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="17" style="width:251.2pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:11.6pt; margin-bottom:0pt; text-indent:-11.6pt; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial;">12.3 &iquest;Tienes apoyo para cuidar a tus hijos o hijas mientras participas en el programa?</span></strong></p>
                    </td>
                    <td colspan="10" style="width:244.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">
                                {{ $participante->apoyohijos->pluck('nombre')->implode(', ') }}
                            </span>
                        </p>
                    </td>
                </tr>
                <tr style="height:8.55pt;">
                    <td colspan="27" style="width:506.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#006666;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N III:</span></strong><strong><span style="font-family:Arial; color:#ffffff;">&nbsp;&nbsp;</span></strong><strong><span style="font-family:Arial; color:#ffffff;">DATOS SOBRE EDUCACI&Oacute;N DE PARTICIPANTE</span></strong></p>
                    </td>
                </tr>
                <tr style="height:6.05pt;">
                    <td colspan="7" style="width:159.05pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="13" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:11.6pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold; list-style-position:inside;">&iquest;Estudia actualmente?</li>
                        </ol>
                    </td>
                    <td colspan="20" style="width:336.9pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">
                               {{ $participante->formatted_estudia_actualmente }}
                            </span>
                    </td>
                </tr>
                <tr style="height:101.3pt;">
                    <td colspan="7" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:14.15pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <strong><span style="font-family:Arial;">13.1 Nivel acad&eacute;mico actual:</span></strong></p>
                    </td>

                    <td colspan="20" style="width:208.3pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:top;">
                        <p style="margin-top:5pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">{{ optional($participante->nivelAcademico)->nombre }}</span>
                            @if(isset($$participante->nivelAcademico))
                            / {{ str($participante->nivelAcademico->categoria)->upper() }}
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="height:20pt;">
                    <td colspan="7" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:14.15pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <strong><span style="font-family:Arial;">13.2 Secci&oacute;n del grado actual:</span></strong>
                        </p>
                    </td>
                    <td colspan="20" style="width:377.55pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">{{ optional($participante->seccionGrado)->nombre }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:30.5pt;">
                    <td colspan="7" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-left:14.15pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <strong><span style="font-family:Arial;">13.3 Turno o jornada en la que estudia:</span></strong></p>
                    </td>
                    <td colspan="20" style="width:377.55pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">{{ optional($participante->turnoEstudio)->nombre }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:50.1pt;">
                    <td colspan="7" style="width:118.4pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="14" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&Uacute;ltimo nivel educativo alcanzado:</li>
                        </ol>
                    </td>
                    <td colspan="20" style="width:366.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">
                            {{ $participante->nivelEducativo->nombre ?? '' }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:18.45pt;">
                    <td colspan="27" style="width:506.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#006666;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N IV: ADICIONAL</span></strong></p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="24" style="width:363.95pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="15" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;Ha participado en a&ntilde;os anteriores en actividades de Glasswing?</li>
                        </ol>
                    </td>
                    <td colspan="3" style="width:132pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">
                               {{ $participante->formatted_participo_glasswing }}
                            </span>
                        </p>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="8" style="width:173.25pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="16" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;Con qu&eacute; rol ha participado?</li>
                        </ol>
                    </td>
                    <td colspan="19" style="width:322.7pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;">
                            <span style="font-family:Arial;">
                                {{ $participante->formatted_rol_participo }}
                            </span>
                    </td>
                </tr>
                <tr style="height:21.25pt;">
                    <td colspan="8" style="width:173.25pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="17" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:18pt; widows:0; orphans:0; font-family:Arial; font-size:11pt; font-weight:bold;">&iquest;En qu&eacute; particip&oacute;?</li>
                        </ol>
                    </td>
                    <td colspan="19" style="width:322.7pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:11pt;"><span style="font-family:Arial;">
                        {{ $participante->descripcion_participo }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:18.45pt;">
                    <td colspan="27" style="width:506.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#006666;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N V: BANCARIZACI&Oacute;N&nbsp;</span></strong><a name="_ftnref2"></a><a href="#_ftn2" style="text-decoration:none;"><strong><span style="font-family:Arial; font-size:7.33pt; color:#ffffff;"></span></strong></a></p>
                    </td>
                </tr>
                <tr style="height:20.1pt;">
                    <td colspan="4" style="width:159.3pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">N&uacute;mero de documento de identidad de participante</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:336.5pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">{{ $participante->documento_identidad }}</span></p>
                    </td>
                </tr>
                 <tr style="height:18.55pt;">
                    <td colspan="4" style="width:208.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="2" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">Correo electr&oacute;nico de participante</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:287.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">{{ $participante->email }}</span></p>
                    </td>
                </tr>
                <tr style="height:18.55pt;">
                    <td colspan="4" style="width:208.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="3" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">N&uacute;mero de tel&eacute;fono de participante</li>
                        </ol>
                    </td>
                    <td colspan="23" style="width:287.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">{{ $participante->telefono }}</span></p>
                    </td>
                </tr>
                @if($participante->nacionalidad == 1)
                    <tr style="height:18.55pt;">
                        <td rowspan="2" colspan="4" style="width:88.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                            <ol start="4" type="1" style="margin:0pt; padding-left:0pt;">
                                <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold; background-color:#f2f2f2;">Lugar de nacimiento</li>
                            </ol>
                        </td>
                        <td colspan="12" style="width:201.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                            <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">{{ $participante->municipioNacimiento->departamento->nombre }}</span></p>
                        </td>
                        <td colspan="11" style="width:195.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                            <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">{{ $participante->municipioNacimiento->nombre }}</span></p>
                        </td>
                    </tr>
                    <tr style="height:18.55pt;">
                        <td colspan="12" style="width:201.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial;">Departamento</span></strong></p>
                        </td>
                        <td colspan="11" style="width:195.1pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                            <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial;">Municipio</span></strong></p>
                        </td>
                    </tr>
                @else
                    <tr style="height:18.55pt;">
                        <td colspan="4" style="width:208.45pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                            <ol start="4" type="1" style="margin:0pt; padding-left:0pt;">
                                <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">Lugar de nacimiento</li>
                            </ol>
                        </td>
                        <td colspan="23" style="width:287.35pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                            <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">
                                {{ $participante->municipio_nacimiento_extranjero.', '.$participante->departamento_nacimiento_extranjero.', '.$participante->pais_nacimiento_extranjero }}
                            </span></p>
                        </td>
                    </tr>
                @endif


                 <tr style="height:22.7pt;">
                    <td colspan="27" style="width:506.6pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="5" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">Nombre completo de persona que asignan como beneficiaria de cuenta bancaria en caso de fallecimiento (Persona mayor de edad)</li>
                        </ol>
                    </td>
                </tr>
                <tr style="height:22.7pt;">
                    <td colspan="27" style="width:506.6pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">
                            {{ $participante->beneficiario_full_name }}
                        </span></p>
                    </td>
                </tr>
               <tr style="height:14pt;">
                    <td colspan="12" style="width:194.75pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <ol start="6" type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt; font-weight:bold;">Parentesco con participante&nbsp;</li>
                        </ol>
                    </td>
                    <td colspan="15" style="width:301.05pt; border-style:solid; border-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:17.45pt; margin-bottom:0pt; text-indent:-14.15pt; font-size:11pt;">
                            <span style="font-family:Arial;">{{ $participante->parentesco->nombre }}</span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p> --}}
        <table cellspacing="0" cellpadding="0" style="width:517.9pt; border:0.75pt solid #000000; border-collapse:collapse;">
            <tbody>
                <tr style="height:14.15pt;">
                    <td colspan="2" style="width:506.35pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#037179;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial; color:#ffffff;">SECCI&Oacute;N VI: ESTATUS DE DOCUMENTACI&Oacute;N&nbsp;</span></strong></p>
                    </td>
                </tr>
                <tr style="height:22.7pt;">
                    <td colspan="2" style="width:506.35pt; border-top-style:solid; border-top-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">Marcar los documentos con que se cuenta para cargar en formulario de inscripci&oacute;n de la persona participante</span></strong></p>
                    </td>
                </tr>
                <tr style="height:11.45pt;">
                    <td style="width:180.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt; background-color:#f2f2f2;"><strong><span style="font-family:Arial;">Documento</span></strong></p>
                    </td>
                    <td style="width:315.2pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:Arial;">Comentario/observaci&oacute;n</span></strong></p>
                    </td>
                </tr>
                <tr style="height:22.7pt;">
                    <td style="width:180.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:10.85pt; margin-bottom:0pt; text-indent:-10.85pt; font-size:11pt;"><span style="font-family:Arial;"></span><strong><span style="font-family:Arial;">Copia de documento de identidad seleccionado de participante</span></strong></p>
                    </td>
                    <td style="width:315.2pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">
                            {{ $participante->comentario_documento_identidad_upload }}
                        </span></strong></p>
                    </td>
                </tr>
                <tr style="height:22.7pt;">
                    <td style="width:180.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:10.85pt; margin-bottom:0pt; text-indent:-10.85pt; font-size:11pt;"><span style="font-family:Arial;"></span><strong><span style="font-family:Arial;">Copia de certificado o constancia de estudios</span></strong></p>
                    </td>
                    <td style="width:315.2pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">
                            {{ $participante->comentario_copia_certificado_estudio_upload }}
                        </span></strong></p>
                    </td>
                </tr>
                <tr style="height:31.2pt;">
                    <td style="width:180.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:10.85pt; margin-bottom:0pt; text-indent:-10.85pt; font-size:11pt;"><span style="font-family:Arial;"></span><strong><span style="font-family:Arial;">Formulario de consentimientos y/o asentimientos para inscripci&oacute;n al programa</span></strong></p>
                    </td>
                    <td style="width:315.2pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">
                            {{ $participante->comentario_formulario_consentimiento_programa_upload }}
                        </span></strong></p>
                    </td>
                </tr>
                <tr style="height:31.2pt;">
                    <td style="width:180.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">Estudio socioecon&oacute;mico&nbsp;</span></strong></p>
                    </td>
                    <td style="width:315.2pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><strong><span style="font-family:Arial;">
                            @if($participante->socioeconomico_count > 0)
                                Si
                            @endif
                        </span></strong></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <table cellspacing="0" cellpadding="0" style="width:506.25pt; margin-left:0.75pt; border-collapse:collapse;">
            <tbody>
                <tr style="height:14.15pt;">
                    <td style="width:223.2pt; border-top-style:solid; border-top-width:0.75pt; border-right:0.75pt solid #ffffff; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#037179;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><a name="_heading_h.1fob9te"></a><strong><span style="font-family:Arial; color:#ffffff;">Elaboraci&oacute;n</span></strong></p>
                    </td>
                    <td style="width:13.2pt; border:0.75pt solid #ffffff; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><strong><span style="font-family:Arial; color:#ffffff;">&nbsp;</span></strong></p>
                    </td>
                    <td style="width:236.7pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle; background-color:#037179;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><strong><span style="font-family:Arial; color:#ffffff;">Validaci&oacute;n</span></strong></p>
                    </td>
                </tr>
                <tr style="height:42.5pt;">
                    <td style="width:223.2pt; border-top-style:solid; border-top-width:0.75pt; border-right:0.75pt solid #ffffff; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Nombre: {{ $participante->gestor->name ?? '' }}</span></p>
                    </td>
                    <td style="width:13.2pt; border:0.75pt solid #ffffff; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:236.7pt; border-top-style:solid; border-top-width:0.75pt; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.4pt 5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Nombre: {{ $participante->lastEstado->coordinador->name }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:42.5pt;">
                    <td style="width:223.2pt; border-top-style:solid; border-top-width:0.75pt; border-right:0.75pt solid #ffffff; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Cargo: Gestor</span></p>
                    </td>
                    <td style="width:13.2pt; border:0.75pt solid #ffffff; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:236.7pt; border-top-style:solid; border-top-width:0.75pt; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.4pt 5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Cargo: Coordinador</span></p>
                    </td>
                </tr>
                <tr style="height:42.5pt;">
                    <td style="width:223.2pt; border-top-style:solid; border-top-width:0.75pt; border-right:0.75pt solid #ffffff; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Firma:</span></p>
                    </td>
                    <td style="width:13.2pt; border:0.75pt solid #ffffff; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:236.7pt; border-top-style:solid; border-top-width:0.75pt; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.4pt 5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Firma:</span></p>
                    </td>
                </tr>
                <tr style="height:42.5pt;">
                    <td style="width:223.2pt; border-top-style:solid; border-top-width:0.75pt; border-right:0.75pt solid #ffffff; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Fecha: {{ $participante->created_at->format("d/m/Y") }}</span></p>
                    </td>
                    <td style="width:13.2pt; border:0.75pt solid #ffffff; padding:5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:236.7pt; border-top-style:solid; border-top-width:0.75pt; border-left:0.75pt solid #ffffff; border-bottom-style:solid; border-bottom-width:0.75pt; padding:5pt 5.4pt 5pt 5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-left:7.45pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Fecha: {{ $participante->lastEstado->created_at->format("d/m/Y") }}</span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <div style="clear:both;">
            <p style="margin-top:0pt; margin-bottom:0pt;">&nbsp;</p>
        </div>
    </div>
    {{-- <hr style="width:33%; height:1px; text-align:left;">
    <div id="_ftn1">
        <p style="margin-top:0pt; margin-bottom:0pt;"><a href="#_ftnref1" style="text-decoration:none;"><span style="font-size:7.33pt; color:#000000;"><sup>[1]</sup></span></a><span style="font-size:10pt;">&nbsp;Acorde a cada proyecto o programa, las alternativas pueden variar.&nbsp;</span></p>
    </div>
    <div id="_ftn2">
        <p style="margin-top:0pt; margin-bottom:0pt;"><a href="#_ftnref2" style="text-decoration:none;"><span style="font-size:7.33pt; color:#000000;"><sup>[2]</sup></span></a><span style="font-size:10pt;">&nbsp;Esta secci&oacute;n puede variar dependiendo de los requerimientos de la instituci&oacute;n financiera en cada pa&iacute;s.&nbsp;</span></p>
    </div> --}}
</body>
</html>
