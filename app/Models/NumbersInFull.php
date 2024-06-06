<?php

namespace App\Models;


class NumbersInFull
{

    private static $UNIDADES = [

        '',
        'um ',
        'dois ',
        'três ',
        'quatro ',
        'cinco ',
        'seis ',
        'sete ',
        'oito ',
        'nove ',
        'dez ',
        'onze ',
        'doze ',
        'treze ',
        'quatorze ',
        'quinze ',
        'dezesseis ',
        'dezessete ',
        'dezoito ',
        'dezenove ',
        'vinte '
    ];



    private static $DEZENAS = [

        'vinte ',

        'trinta ',

        'quarenta ',

        'cinquenta ',

        'sessenta ',

        'setenta ',

        'oitenta ',

        'noventa ',

        'cem '

    ];



    private static $CENTENAS = [

        'cento e ',

        'duzentos e ',

        'trezentos e ',

        'quatrocentos e ',

        'quinhentos e ',

        'seiscentos e ',

        'setecentos e ',

        'oitocentos e ',

        'novecentos e '

    ];



    public static function converter($number, $currency = '', $format = false, $decimals = '')
    {

        $base_number = $number;

        $converted = '';

        $decimals = '';



        if (($base_number < 0) || ($base_number > 999999999)) {

            return 'Não é possível converter esse valor para extenso.';

        }



        $div_decimals = explode('.', $base_number);



        if (count($div_decimals) > 1) {

            $base_number = $div_decimals[0];

            $decNumberStr = (string) $div_decimals[1];

            if (strlen($decNumberStr) == 2) {

                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);

                $decCentos = substr($decNumberStrFill, 6);

                $decimals = self::convertGroup($decCentos);

            }

        }



        $numberStr = (string) $base_number;

        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);

        $milhoes = substr($numberStrFill, 0, 3);

        $mil = substr($numberStrFill, 3, 3);

        $centos = substr($numberStrFill, 6);



        if (intval($milhoes) > 0) {

            if ($milhoes == '001') {

                $converted .= 'um milhão ';

            } else if (intval($milhoes) > 0) {

                $converted .= sprintf('%smilhões ', self::convertGroup($milhoes));

            }

        }



        if (intval($mil) > 0) {

            if ($mil == '001') {

                $converted .= 'mil ';

            } else if (intval($mil) > 0) {

                $converted .= sprintf('%smil ', self::convertGroup($mil));

            }

        }



        if (intval($centos) > 0) {

            if ($centos == '001') {

                $converted .= 'um ';

            } else if (intval($centos) > 0) {

                $converted .= sprintf('%s ', self::convertGroup($centos));

            }

        }



        if ($format) {

            if (empty($decimals)) {

                $valor_convertido = number_format($number, 2, ',', '.') . ' (' . ucfirst($converted) . '00/100 ' . $currency . ')';

            } else {

                $valor_convertido = number_format($number, 2, ',', '.') . ' (' . ucfirst($converted) . $decNumberStr . '/100 ' . $currency . ')';

            }

        } else {

            if (empty($decimals)) {

                $valor_convertido = ucfirst($converted) . $currency;

            } else {

                $valor_convertido = ucfirst($converted) . $currency . ' com ' . $decimals . $decimals;

            }

        }


        return $valor_convertido != 'Reais' ? $valor_convertido : 'Zero Reais';

    }



    private static function convertGroup($n)
    {

        $output = '';



        if ($n == '100') {

            $output = "cem ";

        } else if ($n[0] !== '0') {

            $output = self::$CENTENAS[$n[0] - 1];

        }



        $k = intval(substr($n, 1));



        if ($k <= 20) {

            $output .= self::$UNIDADES[$k];

        } else {

            if (($k > 30) && ($n[2] !== '0')) {

                $output .= sprintf('%se %s', self::$DEZENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);

            } else {

                $output .= sprintf('%s%s', self::$DEZENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);

            }

        }

        return $output;

    }

}