<?php


namespace App\Util;


class FontesUtil
{

    public static function AgruparFontes($fontes)
    {
        $resultado = [];

        $padraoRetirarDatas = '~([0-9]+/)?[0-9]{4}~';
        $padraoPrepararConcat = '~(\(.*\d)~';
        $padraoRetirarDatasParenteses = '~([0-9]+/)?[0-9]{4}|(\(.*\d\))~';
        $padraoBuscarDia = '~([0-9]+/)([0-9]+/)[0-9]{4}|(\(.*\d\))~';
        $padraoRetirarDia = '~([0-9]+/)~';

        foreach ($fontes as $fonte)
        {
            $nova_fonte = true;
            $tamanhoResultado = count($resultado);

            if (preg_match($padraoBuscarDia, $fonte, $matches, PREG_OFFSET_CAPTURE, 0))
            {
                var_dump($matches[1][0]);
                $fonte = str_replace($matches[1][0], '', $fonte);
                //echo 'FONTE: ' . $fonte . ';';
            }


            for ($i = 0; $i < $tamanhoResultado; $i++)
            {

                $fonteSemData = $fonte;
                $fonteSemData = preg_replace($padraoRetirarDatas, '', $fonteSemData);

                $fonteNova = $resultado[$i];
                $fonteNova = preg_replace($padraoRetirarDatasParenteses, '', $fonteNova);

                $matches = null;
                if (trim($fonteNova, " ") === trim($fonteSemData, " "))
                {
                    $nova_fonte = false;

                    if (preg_match($padraoPrepararConcat, $resultado[$i], $matches, PREG_OFFSET_CAPTURE, 0))
                    {
                        $anos = $matches[0][0];

                        if(preg_match($padraoRetirarDatas, $fonte, $matches, PREG_OFFSET_CAPTURE, 0))
                        {
                            $novo_ano = $matches[0][0];

                            $resultado[$i] = $fonteSemData . $anos . ", " . $novo_ano . ")";
                            break;
                        }
                    }
                    else
                    {

                        if(preg_match($padraoRetirarDatas, $fonte, $matches, PREG_OFFSET_CAPTURE, 0))
                        {
                            $novo_ano = $matches[0][0];
                            $resultado[$i] = $fonteSemData . "(" . $novo_ano . ")";
                            break;
                        }
                    }

                }
            }
            if($resultado == null or $nova_fonte == true)
            {
                $resultado[] = $fonte;
            }
        }

        return $resultado;
    }
}