<?php
namespace App\Services;

use App\Models\{Project,Service,Setting,TeamMember};
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class PortfolioPdfBuilder
{
    public function path(): string
    {
        return storage_path('app/portfolio/Impact-Tech-Portfolio.pdf');
    }

    public function build(): string
    {
        $directory=dirname($this->path());
        $tempDirectory=storage_path('app/mpdf');
        if(!is_dir($directory))mkdir($directory,0775,true);
        if(!is_dir($tempDirectory))mkdir($tempDirectory,0775,true);

        $lock=fopen($directory.'/generation.lock','c+');
        if(!$lock||!flock($lock,LOCK_EX|LOCK_NB))return $this->path();

        try{
            $data=[
                'settings'=>Setting::pluck('value','key'),
                'services'=>Service::where('published',true)->orderBy('sort_order')->get(),
                'projects'=>Project::where('published',true)->orderBy('sort_order')->get(),
                'team'=>TeamMember::where('published',true)->orderBy('sort_order')->get(),
            ];
            $mpdf=new Mpdf([
                'mode'=>'utf-8','format'=>'A4-L',
                'margin_left'=>0,'margin_right'=>0,'margin_top'=>0,'margin_bottom'=>0,
                'default_font'=>'dejavusans','tempDir'=>$tempDirectory,
                'simpleTables'=>true,'packTableData'=>true,
            ]);
            $mpdf->SetDirectionality('rtl');
            $mpdf->SetTitle('Impact Tech Company Profile');
            $mpdf->SetAuthor('Impact Tech');
            $css=file_get_contents(public_path('css/portfolio-pdf.css')).file_get_contents(public_path('css/portfolio-pdf-v2.css'));
            $mpdf->WriteHTML($css,HTMLParserMode::HEADER_CSS);
            foreach(range(1,15) as $slide){
                $html=view('portfolio-slide',$data+['slide'=>$slide])->render();
                $mpdf->WriteFixedPosHTML($html,0,0,297,210,'hidden');
                if($slide<15)$mpdf->AddPage('L');
            }
            $temporary=$directory.'/portfolio-'.bin2hex(random_bytes(6)).'.pdf';
            $mpdf->Output($temporary,Destination::FILE);
            rename($temporary,$this->path());
            return $this->path();
        }finally{
            flock($lock,LOCK_UN);
            fclose($lock);
        }
    }
}
