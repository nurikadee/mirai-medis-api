<?php

namespace app\models;

class Bpjs extends \yii\db\ActiveRecord
{
    public static function getMappingRsPolitoBPJS($poliRS)
    {
        $list = [
            "1001" => ["nama" => "ANAK",                   "poli" => ["ANA", "027", "028", "029", "030", "031", "032", "033", "034", "035", "RAA", "004", "037", "038", "039", "040", "041", "087", "101"]],
            "1022" => ["nama" => "BEDAH ANAK",             "poli" => ["BDA", "BED"]],
            "1024" => ["nama" => "BEDAH DIGESTIF",         "poli" => ["018", "BED"]],
            "1026" => ["nama" => "BEDAH KEPALA LEHER",     "poli" => ["170", "BED"]],
            "1006" => ["nama" => "BEDAH MULUT",            "poli" => ["BDM", "BED", "PNM"]],
            "1023" => ["nama" => "BEDAH ONKOLOGI",         "poli" => ["017", "BED", "KEM"]],
            "1003" => ["nama" => "BEDAH ORTHOPEDI",        "poli" => ["ORT", "BED", "152"]],
            "1025" => ["nama" => "BEDAH PLASTIK",          "poli" => ["BDP", "BED", "072", "104", "109"]],
            "1004" => ["nama" => "BEDAH SYARAF",           "poli" => ["BSY", "BED", "BDS", "078", "106"]],
            "1002" => ["nama" => "BEDAH UMUM",             "poli" => ["BED", "104", "105", "107"]],
            "1031" => ["nama" => "BEDAH VASKULER",         "poli" => ["132", "BED", "BTK"]],
            "1005" => ["nama" => "GIGI",                   "poli" => ["GIG", "BDM", "GND", "GOR", "GPR", "GRD", "KON", "PNM", "PTD", "GP1"]],
            "1008" => ["nama" => "JANTUNG",                "poli" => ["JAN", "015"]],
            "1009" => ["nama" => "KANDUNGAN",              "poli" => ["OBG", "020", "023"]],
            "1010" => ["nama" => "KULIT DAN KELAMIN",      "poli" => ["KLT", "ALG", "004", "014", "108"]],
            "1011" => ["nama" => "MATA",                   "poli" => ["MAT"]],
            "1030" => ["nama" => "ONKOLOGI ANAK",          "poli" => ["030", "ANA", "KEM"]],
            "1033" => ["nama" => "ONKOLOGI GINEKOLOGI",    "poli" => ["021", "OBG", "KEM"]],
            "1012" => ["nama" => "PARU",                   "poli" => ["PAR", "100", "012", "073", "096", "097", "098", "099"]],
            "1007" => ["nama" => "PENYAKIT DALAM",         "poli" => ["INT", "IPD", "010", "004", "005", "007", "009", "013", "024", "074", "101"]],
            "3201" => ["nama" => "REHAB MEDIK",            "poli" => ["IRM", "REM", "ORT"]],
            "1014" => ["nama" => "SYARAF",                 "poli" => ["SAR", "068", "077", "079", "080", "081", "082", "083", "084", "085", "087", "IRM"]],
            "1015" => ["nama" => "THT",                    "poli" => ["THT", "075", "067", "069", "070", "075"]],
            "1035" => ["nama" => "UROGINEKOLOGI",          "poli" => ["022", "OBG", "URO"]],
            "1013" => ["nama" => "UROLOGI",                "poli" => ["URO", "007"]],
            "1018" => ["nama" => "KEDOKTERAN JIWA",        "poli" => ["JIW", "011", "040", "041"]],
            "1034" => ["nama" => "HEMATO ONKOLOGI DEWASA", "poli" => ["008", "INT"]],
            "1017" => ["nama" => "GIZI",                   "poli" => ["035"]],
            "1029" => ["nama" => "ANESTHESI",              "poli" => ["044", "046", "048", "049", "045", "047"]],
            "1038" => ["nama" => "OKUPASI",                "poli" => ["KDO"]],
            "1020" => ["nama" => "PROSTHODONTIE",          "poli" => ["PTD", "GIG"]],
            "1032" => ["nama" => "RADIO THERAPI",          "poli" => ["168"]],
            "1036" => ["nama" => "FERTILITY",              "poli" => ["025"]],
            "1028" => ["nama" => "THALASEMIA",             "poli" => ["ANA", "030"]],
            "3601" => ["nama" => "HEMODIALISA",            "poli" => ["HDL", "CAP"]],
            "1019" => ["nama" => "ORTHODONTIE",            "poli" => ["GOR", "GIG"]],
            "3101" => ["nama" => "RADIOLOGI",              "poli" => ["RAD"]],
            "3102" => ["nama" => "POLI RADIOTERAPI",       "poli" => ["RAT"]],
            "3409" => ["nama" => "TREADMIL TEST",          "poli" => ["TRD"]],
            "1027" => ["nama" => "TB DOTS",                "poli" => ["PAR"]],
            "1027" => ["nama" => "TB. MDR",                "poli" => ["PAR"]],
        ];
        if (isset($list[$poliRS])) {
            return $list[$poliRS];
        }
        return false;
    }
}
