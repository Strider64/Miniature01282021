<?php

use JetBrains\PhpStorm\Pure;

class Room {
    public function __construct(private float $width, private float $length, private string $roomName) {
    }

    #[Pure] private function convertToImperial(float $x): string {
        $valInFeet = $x * 3.2808399;
        $valFeet = (int)$valInFeet;
        $valInches = round(($valInFeet-$valFeet) * 12);
        return $valFeet."&prime; ".$valInches."&Prime;";
    }

    public function imperialWidth(): string {
        return $this->convertToImperial($this->width);
    }

    public function imperialLength(): string {
        return $this->convertToImperial($this->length);
    }
}

$foo = new Room(15,12, "bedroom");

echo "Imperial Width : " . $foo->imperialWidth() . "<br>";
echo "Imperial Length : " . $foo->imperialLength() . "<br>";
