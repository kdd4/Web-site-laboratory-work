<?php
namespace Models;

use \GMP;

use \Core\ActiveRecordModel;

class PrimeModel extends ActiveRecordModel {
    protected static array $fields = ['length', 'result', 'time'];

    protected static string $tablename = 'prime';

    public function __construct()
    {
        parent::__construct();
    }

    private static function rand($bits): GMP {
        $val = gmp_random_range(gmp_pow(2, $bits - 1), gmp_pow(2, $bits + 1));

        gmp_setbit($val, 0);

        return $val;
    }

    public function generate() {
        $bits = $this->length;

        $iteration = 0;
        $maxIteration = 1000;

        while (true) {
            if ($iteration++ > $maxIteration) {
                $this->result = 'failed';
                $this->save();
                return;
            }

            $value = static::rand($bits);

            for ($i = 0; $i < 100; $i++) {
                do {
                    $checkValue = static::rand($bits * 2);
                } while (gmp_mod($checkValue, $value) == 0);

                if (gmp_powm($checkValue, gmp_sub($value, 1), $value) != 1) {
                    continue 2;
                }
            }

            $this->result = gmp_strval($value);
            $this->save();
            return;
        }
    }
}