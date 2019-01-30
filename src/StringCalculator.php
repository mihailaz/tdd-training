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
        $delimiter = $this->parseHeader($str);
        $str = str_replace("\n", ',', $str);

        if (preg_match('/\,{2,}/', $str)) {
            throw new StringCalculatorException('Invalid format');
        }

        return array_reduce(explode(',', $str), [$this, 'addReduce'], 0);
    }

    /**
     * @param int $r
     * @param string $n
     * @return int
     */
    private function addReduce(int $r, string $n)
    {
//        $n = trim($n);
//
//        if ($n && !is_numeric($n)) {
//            throw new \DomainException("Invalid number: {$n}");
//        }

        return $r + (int)$n;
    }

    private function parseHeader(&$str)
    {
        if (!preg_match("#//.\n#", $str)) {
            return ",\n";
        }

        return;
    }
}
