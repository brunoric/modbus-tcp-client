<?php
namespace ModbusTcpClient\Packet\ModbusFunction;

use ModbusTcpClient\Packet\IModbusPacket;
use ModbusTcpClient\Packet\ProtocolDataUnitResponse;
use ModbusTcpClient\Utils\Types;

/**
 * Response for Read Coils (FC=01)
 */
class ReadCoilsResponse extends ProtocolDataUnitResponse
{

    public function getFunctionCode()
    {
        return IModbusPacket::READ_COILS;
    }

    public static function parse($binaryString)
    {
        // TODO: Implement parse() method.
    }

    public function getCoils()
    {
        return Types::binaryStringToBooleanArray($this->getRawData());
    }
}