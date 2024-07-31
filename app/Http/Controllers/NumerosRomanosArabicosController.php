<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use InvalidArgumentException;

class NumerosRomanosArabicosController extends Controller
{
    public function receberNumeroRomano(Request $request)
    {
        $romano = $request->numero;
        $this->converterRomanoParaArabico($romano);
    }

    // Método para converter número romano para arábico
    private function converterRomanoParaArabico($romano)
    {

        try {
            // Converte o número romano para maiúsculas
            $romano = strtoupper($romano);
    
            // Mapeamento dos números romanos para seus valores arábicos
            $numeroRomanosArabicos = [
                'M' => 1000,
                'D' => 500,
                'C' => 100,
                'L' => 50,
                'X' => 10,
                'V' => 5,
                'I' => 1
            ];
    
            // Verifica se a string contém caracteres válidos
            if (preg_match('/[^MDCLXVI]/', $romano)) {
                throw new InvalidArgumentException('romano invalido.');
            }
    
            $length = strlen($romano);
            $arabico = 0;
            $prevValue = 0;
    
            // Percorre cada caractere do número romano
            for ($i = $length - 1; $i >= 0; $i--) {
                $currentChar = $romano[$i];
    
                // Verifica se o caractere atual é válido
                if (!isset($numeroRomanosArabicos[$currentChar])) {
                    throw new InvalidArgumentException('romano invalido.');
                }
    
                $currentValue = $numeroRomanosArabicos[$currentChar];
    
                // Se o valor atual é menor que o valor anterior, subtrai-o, caso contrário, soma-o
                if ($currentValue < $prevValue) {
                    $arabico -= $currentValue;
                } else {
                    $arabico += $currentValue;
                }
    
                // Atualiza o valor anterior
                $prevValue = $currentValue;
            }
    
            // Retorna o número arábico como JSON
            echo json_encode($arabico);
    
        } catch (InvalidArgumentException $e) {
            // Captura e trata exceções relacionadas a argumentos inválidos
            echo json_encode( $e->getMessage());
        } catch (Exception $e) {
            // Captura e trata qualquer outra exceção
            echo json_encode($e->getMessage());
        }
    }

    public function receberNumeroArabico(Request $request)
    {
        $arabico = $request->numero;
        $this->converterArabicoParaRomano($arabico);
    }

    // Método para converter número romano para arábico
    private function converterArabicoParaRomano($arabico)
    {
        try {
            // Verifica se o número arábico é válido
            if (!ctype_digit($arabico) || $arabico <= 0) {
                throw new InvalidArgumentException('arabico invalido.');
            }
    
            // Mapeamento dos valores arábicos para seus símbolos romanos
            $numerosArabicosRomanos = [
                1000 => 'M',
                900  => 'CM',
                500  => 'D',
                400  => 'CD',
                100  => 'C',
                90   => 'XC',
                50   => 'L',
                40   => 'XL',
                10   => 'X',
                9    => 'IX',
                5    => 'V',
                4    => 'IV',
                1    => 'I'
            ];
    
            $romano = '';
    
            // Itera sobre cada valor arábico começando do maior
            foreach ($numerosArabicosRomanos as $value => $simbolo) {
                // Calcula quantas vezes o símbolo se encaixa no número
                while ($arabico >= $value) {
                    $romano .= $simbolo;
                    $arabico -= $value;
                }
            }
    
            // Retorna o número romano como JSON
            echo json_encode($romano);
    
        } catch (InvalidArgumentException $e) {
            // Captura e trata exceções relacionadas a argumentos inválidos
            echo json_encode($e->getMessage());
        } catch (Exception $e) {
            // Captura e trata qualquer outra exceção inesperada
            echo json_encode($e->getMessage());
        }
    }
}
