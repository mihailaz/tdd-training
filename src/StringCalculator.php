<?php
/**
 * @license Commerce License Jet Infosystems
 */
namespace App;

use App\Exception\StringCalculatorException;

/**
 * Class StringCalculator
 *
 * @package App
 *
 * @author Michael Lazarev
 */
class StringCalculator
{
    /**
     * @param string $str
     * @return int
     */
    public function add(string $str): int
    {
        $delimiters = str_split($this->parseHeader($str));
        $firstDelimiter = array_shift($delimiters);

        if ($delimiters){
            $str = str_replace($delimiters, $firstDelimiter, $str);
        }
        $quotedDelimiter = preg_quote($firstDelimiter, '/');

        if (preg_match("/{$quotedDelimiter}{2,}/", $str)) {
            throw new StringCalculatorException('Invalid format');
        }

        return array_reduce(explode($firstDelimiter, $str), [$this, 'addReduce'], 0);
    }

    /**
     * @param int $r
     * @param string $n
     * @return int
     */
    private function addReduce(int $r, string $n): int
    {
        return $r + (int)$n;
    }

    /**
     * @param string $str
     * @return string
     */
    private function parseHeader(string &$str): string
    {
        if (!preg_match("#//(.)\n(.*)#", $str, $matches)) {
            return ",\n";
        }
        $str = $matches[2] ?? '';

        return $matches[1];
    }
}
