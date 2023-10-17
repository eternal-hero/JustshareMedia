<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaxRates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxRates =[
            ['state_name' => 'Alabama', 'state_iso_code' => 'AL'],
            ['state_name' => 'Alaska', 'state_iso_code' => 'AK'],
            ['state_name' => 'Arizona', 'state_iso_code' => 'AZ'],
            ['state_name' => 'Arkansas', 'state_iso_code' => 'AR'],
            ['state_name' => 'California', 'state_iso_code' => 'CA'],
            ['state_name' => 'Colorado', 'state_iso_code' => 'CO'],
            ['state_name' => 'Connecticut', 'state_iso_code' => 'CT'],
            ['state_name' => 'Delaware', 'state_iso_code' => 'DE'],
            ['state_name' => 'Florida', 'state_iso_code' => 'FL'],
            ['state_name' => 'Georgia', 'state_iso_code' => 'GA'],
            ['state_name' => 'Hawaii', 'state_iso_code' => 'HI'],
            ['state_name' => 'Idaho', 'state_iso_code' => 'ID'],
            ['state_name' => 'Illinois', 'state_iso_code' => 'IL'],
            ['state_name' => 'Indiana', 'state_iso_code' => 'IN'],
            ['state_name' => 'Iowa', 'state_iso_code' => 'IA'],
            ['state_name' => 'Kansas', 'state_iso_code' => 'KS'],
            ['state_name' => 'Kentucky', 'state_iso_code' => 'KY'],
            ['state_name' => 'Louisana', 'state_iso_code' => 'LA'],
            ['state_name' => 'Maine', 'state_iso_code' => 'ME'],
            ['state_name' => 'Maryland', 'state_iso_code' => 'MD'],
            ['state_name' => 'Massachusetts', 'state_iso_code' => 'MA'],
            ['state_name' => 'Michigan', 'state_iso_code' => 'MI'],
            ['state_name' => 'Minnesota', 'state_iso_code' => 'MN'],
            ['state_name' => 'Mississippi', 'state_iso_code' => 'MS'],
            ['state_name' => 'Missouri', 'state_iso_code' => 'MO'],
            ['state_name' => 'Montana', 'state_iso_code' => 'MT'],
            ['state_name' => 'Nebraska', 'state_iso_code' => 'NE'],
            ['state_name' => 'Nevada', 'state_iso_code' => 'NV'],
            ['state_name' => 'New Hampshire', 'state_iso_code' => 'NH'],
            ['state_name' => 'New Jersey', 'state_iso_code' => 'NJ'],
            ['state_name' => 'New Mexico', 'state_iso_code' => 'NM'],
            ['state_name' => 'New York', 'state_iso_code' => 'NY'],
            ['state_name' => 'North Carolina', 'state_iso_code' => 'NC'],
            ['state_name' => 'North Dakota', 'state_iso_code' => 'ND'],
            ['state_name' => 'Ohio', 'state_iso_code' => 'OH'],
            ['state_name' => 'Oklahoma', 'state_iso_code' => 'OK'],
            ['state_name' => 'Oregon', 'state_iso_code' => 'OR'],
            ['state_name' => 'Pensylvania', 'state_iso_code' => 'PA'],
            ['state_name' => 'Rhode Island', 'state_iso_code' => 'PI'],
            ['state_name' => 'South Carolina', 'state_iso_code' => 'SC'],
            ['state_name' => 'South Dakota', 'state_iso_code' => 'SD'],
            ['state_name' => 'Tennessee', 'state_iso_code' => 'TN'],
            ['state_name' => 'Texas', 'state_iso_code' => 'TX'],
            ['state_name' => 'Utah', 'state_iso_code' => 'UT'],
            ['state_name' => 'Vermont', 'state_iso_code' => 'VT'],
            ['state_name' => 'Virginia', 'state_iso_code' => 'VA'],
            ['state_name' => 'Washington', 'state_iso_code' => 'WA'],
            ['state_name' => 'West Virginia', 'state_iso_code' => 'WV'],
            ['state_name' => 'Wisconsin', 'state_iso_code' => 'WI'],
            ['state_name' => 'Wyoming', 'state_iso_code' => 'WY'],
            ['state_name' => 'District of Columbia', 'state_iso_code' => 'DC']
        ];

        foreach ($taxRates as $taxRate) {
            \App\Models\TaxRate::create($taxRate);
        }
    }
}
