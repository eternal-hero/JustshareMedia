<?php

namespace App;

class Helpers {
    static function getStates()
    {
        return [
            ['name' => 'Alabama', 'iso' => 'AL'],
            ['name' => 'Alaska', 'iso' => 'AK'],
            ['name' => 'Arizona', 'iso' => 'AZ'],
            ['name' => 'Arkansas', 'iso' => 'AR'],
            ['name' => 'California', 'iso' => 'CA'],
            ['name' => 'Colorado', 'iso' => 'CO'],
            ['name' => 'Connecticut', 'iso' => 'CT'],
            ['name' => 'Delaware', 'iso' => 'DE'],
            ['name' => 'Florida', 'iso' => 'FL'],
            ['name' => 'Georgia', 'iso' => 'GA'],
            ['name' => 'Hawaii', 'iso' => 'HI'],
            ['name' => 'Idaho', 'iso' => 'ID'],
            ['name' => 'Illinois', 'iso' => 'IL'],
            ['name' => 'Indiana', 'iso' => 'IN'],
            ['name' => 'Iowa', 'iso' => 'IA'],
            ['name' => 'Kansas', 'iso' => 'KS'],
            ['name' => 'Kentucky', 'iso' => 'KY'],
            ['name' => 'Louisana', 'iso' => 'LA'],
            ['name' => 'Maine', 'iso' => 'ME'],
            ['name' => 'Maryland', 'iso' => 'MD'],
            ['name' => 'Massachusetts', 'iso' => 'MA'],
            ['name' => 'Michigan', 'iso' => 'MI'],
            ['name' => 'Minnesota', 'iso' => 'MN'],
            ['name' => 'Mississippi', 'iso' => 'MS'],
            ['name' => 'Missouri', 'iso' => 'MO'],
            ['name' => 'Montana', 'iso' => 'MT'],
            ['name' => 'Nebraska', 'iso' => 'NE'],
            ['name' => 'Nevada', 'iso' => 'NV'],
            ['name' => 'New Hampshire', 'iso' => 'NH'],
            ['name' => 'New Jersey', 'iso' => 'NJ'],
            ['name' => 'New Mexico', 'iso' => 'NM'],
            ['name' => 'New York', 'iso' => 'NY'],
            ['name' => 'North Carolina', 'iso' => 'NC'],
            ['name' => 'North Dakota', 'iso' => 'ND'],
            ['name' => 'Ohio', 'iso' => 'OH'],
            ['name' => 'Oklahoma', 'iso' => 'OK'],
            ['name' => 'Oregon', 'iso' => 'OR'],
            ['name' => 'Pensylvania', 'iso' => 'PA'],
            ['name' => 'Rhode Island', 'iso' => 'PI'],
            ['name' => 'South Carolina', 'iso' => 'SC'],
            ['name' => 'South Dakota', 'iso' => 'SD'],
            ['name' => 'Tennessee', 'iso' => 'TN'],
            ['name' => 'Texas', 'iso' => 'TX'],
            ['name' => 'Utah', 'iso' => 'UT'],
            ['name' => 'Vermont', 'iso' => 'VT'],
            ['name' => 'Virginia', 'iso' => 'VA'],
            ['name' => 'Washington', 'iso' => 'WA'],
            ['name' => 'West Virginia', 'iso' => 'WV'],
            ['name' => 'Wisconsin', 'iso' => 'WI'],
            ['name' => 'Wyoming', 'iso' => 'WY'],
            ['name' => 'District of Columbia', 'iso' => 'DC'],
        ];
    }

    /**
     * Get available order terms.
     *
     * @return array $terms
     */
    static function getOrderTerms()
    {
        return ['monthly', 'yearly', 'contract'];
    }
}