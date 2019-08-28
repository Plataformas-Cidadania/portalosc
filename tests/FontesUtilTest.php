<?php

use \App\Util\FontesUtil;

class FontesUtilTest extends TestCase
{

    public function testAgruparFontes()
    {
        echo("...iniciando o teste ....\n");

        $fontes = [
            "CADSOL/MTE", "CADSOL/MTE 2015", "CADSOL/MTE 2016", "CADSOL/MTE 2017"
            ,
            "Censo SUAS 06/2017",
            "Censo SUAS 07/2017",
            "Censo SUAS 08/2017",
            "CEBAS/MS 2017",
            "CNEAS/MDS 2017",
            "Censo SUAS 08/2017",
            "CNES/MS 2017",
            "OSCIP/MJ",
            "LIE/MESP 2017",
            "CEBAS/MDS 2017",
            "RAIS/MTE",
            "CNPJ/SRF/MF 2016",
            "CEBAS/MEC 10/2017",
            "CNEAS/MDS"];

        $resultado = FontesUtil::AgruparFontes($fontes);

        /*
        $cont3 = 0;
        $resultado = [];

        $padraoRetirarDatas = '~([0-9]+/)?[0-9]{4}~';
        $padraoPrepararConcat = '~(\(.*\d)~';
        $padraoRetirarDatasParenteses = '~([0-9]+/)?[0-9]{4}|(\(.*\d\))~';

        foreach ($fontes as $fonte)
        {

            $nova_fonte = true;
            $tamanhoResultado = count($resultado);

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
        */
        echo "VETOR RESULTADO:";
        var_dump($resultado);


        echo("\n...fim  do teste ....");
    }
}
