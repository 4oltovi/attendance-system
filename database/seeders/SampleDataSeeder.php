<?php
namespace Database\Seeders;
use App\Models\{Faculty, Specialty, Course, Group, Student};
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder {
    public function run(): void {
        $courses = [];
        for ($i = 1; $i <= 5; $i++) {
            $courses[$i] = Course::create(['course_number'=>$i,'name'=>"Курси {$i}",'description'=>"Соли {$i}-уми таҳсил",'is_active'=>true]);
        }
        $facultyData = [
            ['name'=>'Факултети технологияҳои иттилоотӣ','specialties'=>['Информатика','Амнияти иттилоотӣ','Барномасозӣ']],
            ['name'=>'Факултети иқтисод','specialties'=>['Иқтисоди миллӣ','Муҳосибот ва аудит','Менеҷменти молиявӣ']],
            ['name'=>'Факултети ҳуқуқшиносӣ','specialties'=>['Ҳуқуқи гражданӣ','Ҳуқуқи ҷиноятӣ','Ҳуқуқи байналмилалӣ']],
        ];
        $names = [['Алиев','Валӣ'],['Раҳимов','Фирдавс'],['Каримова','Мадина'],['Ҳасанов','Рустам'],['Файзуллоев','Баҳром']];
        foreach ($facultyData as $fData) {
            $faculty = Faculty::create(['name'=>$fData['name'],'is_active'=>true]);
            foreach ($fData['specialties'] as $specName) {
                $specialty = Specialty::create(['faculty_id'=>$faculty->id,'name'=>$specName,'is_active'=>true]);
                for ($c = 1; $c <= 3; $c++) {
                    $group = Group::create(['faculty_id'=>$faculty->id,'specialty_id'=>$specialty->id,'course_id'=>$courses[$c]->id,'name'=>mb_substr($specName,0,3)."-{$c}01",'academic_year'=>'2025-2026','is_active'=>true]);
                    for ($s = 0; $s < 5; $s++) {
                        $n = $names[$s];
                        Student::create(['first_name'=>$n[1],'last_name'=>$n[0],'gender'=>str_ends_with($n[0],'а')?'female':'male','faculty_id'=>$faculty->id,'specialty_id'=>$specialty->id,'course_id'=>$courses[$c]->id,'group_id'=>$group->id,'enrollment_year'=>(string)(2026-$c),'is_active'=>true]);
                    }
                }
            }
        }
    }
}
