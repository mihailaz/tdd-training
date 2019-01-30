<?php
/**
 * @license Commerce License Jet Infosystems
 */
namespace App\Tests\Unit;

use App\Exception\StringCalculatorException;
use App\StringCalculator;

/**
 * Class StringCalculatorTest
 *
 * @package App\Tests
 *
 * @author Michael Lazarev
 */
class StringCalculatorTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;
    /** @var StringCalculator */
    protected $calc;

    /**
     * @throws \Exception
     */
    protected function _before(): void
    {
        $this->calc = $this->makeEmptyExcept(StringCalculator::class, 'add');
    }

// требование складывать 0,1,2 чисел в строке

    public function testAdd_EmptyString_ReturnsZero(): void
    {
        $result = $this->calc->add('');
        $this->assertEquals(0, $result);
    }

    /**
     * @dataProvider getSingleNumberData
     * @param string $str
     * @param int $expected
     */
    public function testAdd_SingleNumber_ReturnsThatNumber(string $str, int $expected): void
    {
        $result = $this->calc->add($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getSingleNumberData(): array
    {
        return [
            ['1', 1],
            ['2', 2],
            ['3', 3],
        ];
    }

    /**
     * @dataProvider getTwoNumbersData
     * @param string $str
     * @param int $expected
     */
    public function testAdd_TwoNumbers_ReturnsSum(string $str, int $expected): void
    {
        $result = $this->calc->add($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getTwoNumbersData(): array
    {
        return [
            ['1, 2', 3],
            ['2, 3', 5],
            ['3, 4', 7],
        ];
    }

// пришло новое требование: складывать n чисел в строке

    /**
     * @dataProvider getTwoNumbersData
     * @param string $str
     * @param int $expected
     */
    public function testAdd_MultipleNumbers_ReturnsSum(string $str, int $expected): void
    {
        $result = $this->calc->add($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getMultipleNumbersData(): array
    {
        return [
            ['1, 2',        3],
            ['2, 3, 4',     9],
            ['3, 4, 5, 6', 18],
        ];
    }

// еще новые требования: можно использовать в качестве разделителя \n
// но если 2 разделителя - исключение

    public function testAdd_NewLineAndCommaBetweenNumbers_ReturnsSum(): void
    {
        $result = $this->calc->add("1\n2,3");
        $this->assertEquals(6, $result);
    }

    /**
     * @dataProvider getMultipleDelimiterData
     * @param string $str
     */
    public function testAdd_MultipleDelimiter_ThrowsException(string $str): void
    {
        $this->tester->expectThrowable(StringCalculatorException::class, function () use ($str) {
            $this->calc->add($str);
        });
    }

    /**
     * @return array
     */
    public function getMultipleDelimiterData(): array
    {
        return [
            ['1,,'],
            ["1,\n"],
            ["1\n\n"],
        ];
    }

// снова новое стребование: могут быть разные разделители
// в первой строке указывается "//[delimiter]\n[numbers...]" например "//;\n1;2"

    /**
     * @dataProvider getDelimiterOnHeaderData
     * @param string $str
     * @param int $expected
     */
    public function testAdd_DelimiterOnHeader_ReturnsSum(string $str, int $expected): void
    {
        $result = $this->calc->add($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getDelimiterOnHeaderData(): array
    {
        return [
            ["//;\n1;2", 3],
            ["//-\n1-2", 3],
        ];
    }

// todo: не читаемо, нужно каждое правило в отдельном тест кейсе, чтоб по имени теста понимать что пошло не так
// не нужно думать наперед, вперед требований, итеративно, лениво, лучше парой
// шаблон имени тест кейса {MethodName}_{Input}_{Expected}
// только 1 assert на тест

//    /**
//     * @dataProvider getTestAddPositiveData
//     * @param string $str
//     * @param int $expected
//     */
//    public function testAdd_Valid_ReturnsExpected(string $str, int $expected): void
//    {
//        $result = $this->calc->add($str);
//        $this->assertEquals($expected, $result);
//    }
//
//    /**
//     * @return array
//     */
//    public function getTestAddPositiveData(): array
//    {
//        return [
//            'empty'         => ['',                   0],
//            'single'        => ['1',                  1],
//            'two'           => ['1,2',                3],
//            //
//            'white spaces'  => [" \t1 \n, \r2,  ",    3],
//            'float'         => ['1.2, 3.45',       4.65],
//            'int and float' => ['1, 1.2, 2, 3.45', 7.65],
//            'float and int' => ['1.2, 1, 3.45, 2', 7.65],
//        ];
//    }
//
//    /**
//     * @dataProvider getInvalidStringData
//     * @param string $str
//     */
//    public function testAdd_InvalidString_ThrowsException(string $str): void
//    {
//        /** @var StringCalculator $calc */
//        $calc = $this->makeEmptyExcept(StringCalculator::class, 'add');
//
//        $this->tester->expectThrowable(\DomainException::class, function () use ($str, $calc) {
//            $calc->add($str);
//        });
//    }
//
//    /**
//     * @return array
//     */
//    public function getInvalidStringData(): array
//    {
//        return [
//            'text'                 => ['some text'],
//            'text and number'      => ['other text, 1111'],
//            'text between numbers' => ['1, other text, 2'],
//        ];
//    }
}
