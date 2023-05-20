<?php

namespace Rohitgautam\Icon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SvgIconHelper 
{
    public function processCustomClassDirective($expression)
    {        
        // Process the $expression and extract the value
        $value = trim($expression, " '");                
        // Array of class-value-to-icon mappings
        if(config('icons.sets.table_name') === "")
        {
            if(config('icons.sets.path') === "")
            {
                $searchValue = __DIR__ . '/../resources/icons/'.$value.'.svg';
                $svgFiles = File::glob(__DIR__ . '/../resources' . '/**/*.svg');                        
            }else
            {            
                $searchValue = resource_path().'/'.config('icons.sets.path').'/'.$value.'.svg';   
                $svgFiles = File::glob(resource_path() . '/**/*.svg');                   
            }                  
            if (in_array($searchValue, $svgFiles)) 
            {                                   
                return file_get_contents($searchValue);
            }             
        }else
        {            
            $data = DB::table(config('icons.sets.table_name'))->where('name', $value)->first();            
            $template = file_get_contents(__DIR__ . '/../resources/icons/template.svg');             
            $modifiedTemplate = str_replace('{{svg_data}}', $data->svg_code, $template);
            // Modify the SVG template using the retrieved data            
            $modifiedSvg = file_put_contents(__DIR__ . '/../resources/icons/template.svg',$modifiedTemplate);                        
            // Return the generated SVG as a response
            return response($modifiedSvg)->header('Content-Type', 'image/svg+xml');
        }  
    }     
}