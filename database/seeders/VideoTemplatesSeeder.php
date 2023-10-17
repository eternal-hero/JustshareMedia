<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VideoTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videoTemplates =[

            ['title' => 'temp1a', 'path' => 'public/video_templates/temp1a.png'],
            ['title' => 'temp1b', 'path' => 'public/video_templates/temp1b.png'],
            ['title' => 'temp1c', 'path' => 'public/video_templates/temp1c.png'],
            ['title' => 'temp2a', 'path' => 'public/video_templates/temp2a.png'],
            ['title' => 'temp2b', 'path' => 'public/video_templates/temp2b.png'],
            ['title' => 'temp3a', 'path' => 'public/video_templates/temp3a.png'],
            ['title' => 'temp3b', 'path' => 'public/video_templates/temp3b.png'],
            ['title' => 'temp4a', 'path' => 'public/video_templates/temp4a.png'],
            //additional templates from JUST-95
            ['title' => 'temp5a', 'path' => 'public/video_templates/temp5a.png'],
            ['title' => 'temp5b', 'path' => 'public/video_templates/temp5b.png'],
            ['title' => 'temp5c', 'path' => 'public/video_templates/temp5c.png'],
            ['title' => 'temp6a', 'path' => 'public/video_templates/temp6a.png'],
            //additional templates from JUST-147
            ['title' => 'temp7', 'path' => 'public/video_templates/temp7.png'],
            ['title' => 'temp8', 'path' => 'public/video_templates/temp8.png'],
            ['title' => 'temp9', 'path' => 'public/video_templates/temp9.png'],
            ['title' => 'temp10', 'path' => 'public/video_templates/temp10.png'],
            ['title' => 'temp11', 'path' => 'public/video_templates/temp11.png'],
            ['title' => 'temp12', 'path' => 'public/video_templates/temp12.png'],
            ['title' => 'temp13', 'path' => 'public/video_templates/temp13.png'],
            ['title' => 'temp14', 'path' => 'public/video_templates/temp14.png'],
            ['title' => 'temp15', 'path' => 'public/video_templates/temp15.png'],
            ['title' => 'temp16', 'path' => 'public/video_templates/temp16.png'],
            ['title' => 'temp17', 'path' => 'public/video_templates/temp17.png'],
            ['title' => 'temp18', 'path' => 'public/video_templates/temp18.png'],
            ['title' => 'temp19', 'path' => 'public/video_templates/temp19.png'],
            ['title' => 'temp20', 'path' => 'public/video_templates/temp20.png'],
            ['title' => 'temp21', 'path' => 'public/video_templates/temp21.png'],
            ['title' => 'temp22', 'path' => 'public/video_templates/temp22.png'],
            ['title' => 'temp23', 'path' => 'public/video_templates/temp23.png'],
            ['title' => 'temp24', 'path' => 'public/video_templates/temp24.png'],
            ['title' => 'temp25', 'path' => 'public/video_templates/temp25.png'],
            ['title' => 'temp26', 'path' => 'public/video_templates/temp26.png'],
            ['title' => 'temp27', 'path' => 'public/video_templates/temp27.png'],
            ['title' => 'temp28', 'path' => 'public/video_templates/temp28.png'],
            ['title' => 'temp29', 'path' => 'public/video_templates/temp29.png'],
            ['title' => 'temp30', 'path' => 'public/video_templates/temp30.png'],
            ['title' => 'temp31', 'path' => 'public/video_templates/temp31.png'],
            ['title' => 'temp32', 'path' => 'public/video_templates/temp32.png'],
            ['title' => 'temp33', 'path' => 'public/video_templates/temp33.png'],
            ['title' => 'temp34', 'path' => 'public/video_templates/temp34.png'],
            ['title' => 'temp35', 'path' => 'public/video_templates/temp35.png'],
        ];

        foreach ($videoTemplates as $videoTemplate) {
            \App\Models\VideoTemplates::create($videoTemplate);
        }
    }
}
