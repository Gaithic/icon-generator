<?php

namespace Rohitgautam\Icon;

class SvgIconHelper 
{
    public function processCustomClassDirective($expression)
    {        
        // Process the $expression and extract the value
        $value = trim($expression, " '");        
        
        // Array of class-value-to-icon mappings

        $iconMappings = include('icons.php');          
        //check the value of directive and iconmapping 
        if(isset($iconMappings[$value])){                     
            $iconPath = $iconMappings[$value];            
            // Generate the HTML for the SVG icon
            $path = __DIR__ . '/../resources/';                        
            $iconHtml = file_get_contents($path.$iconPath);            
            return $iconHtml;
        }        
        return '';                
    }   
}