<?php

namespace Tests\Packet;


use ModbusTcpClient\Packet\DoubleWord;
use PHPUnit\Framework\TestCase;

class DoubleWordTest extends TestCase
{
    public function testShouldConstructFromShorterData()
    {
        $dWord = new DoubleWord("\x7F\xFF");

        $this->assertEquals("\x00\x00\x7F\xFF", $dWord->getData());
    }

    /**
     * @expectedException \ModbusTcpClient\ModbusException
     * @expectedExceptionMessage Word can only be constructed from 1 to 4 bytes. Currently 5 bytes was given!
     */
    public function testShouldNotConstructFromLongerData()
    {
        new DoubleWord("\x01\x02\x03\x04\x05");
    }

    public function testShouldGetUInt32()
    {
        $dWord = new DoubleWord("\xFF\xFF\x7F\xFF");

        $this->assertEquals(2147483647, $dWord->getUInt32());
    }

    public function testShouldGetInt32()
    {
        $dWord = new DoubleWord("\x00\x00\x80\x00");

        $this->assertEquals(-2147483648, $dWord->getInt32());
    }

    public function testShouldGetFloat()
    {
        $dWord = new DoubleWord("\xaa\xab\x3f\x2a");

        $this->assertEquals(0.6666666, $dWord->getFloat(), null, 0.0000001);
    }

    public function testShouldGetLowBytesAsWord()
    {
        $dWord = new DoubleWord("\xaa\xab\x3f\x2a");

        $this->assertEquals("\x3f\x2a", $dWord->getLowBytesAsWord()->getData());
    }

    public function testShouldGetHighBytesAsWord()
    {
        $dWord = new DoubleWord("\xaa\xab\x3f\x2a");

        $this->assertEquals("\xaa\xab", $dWord->getHighBytesAsWord()->getData());
    }

    public function testShouldCombineToQuadWord()
    {
        $lowDoubleWord = new DoubleWord("\xaa\xab\x3f\x2a");
        $highDoubleWord = new DoubleWord("\x01\x02\x03\x04");

        $quadWord = $highDoubleWord->combine($lowDoubleWord);

        $this->assertEquals("\x01\x02\x03\x04\xaa\xab\x3f\x2a", $quadWord->getData());
    }

}