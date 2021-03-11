<?php
namespace App\Core\Support;

class Tent {

    protected array $viewTree = [];


    public static function putUp(string $viewContent)
    {
        $tent = new self();

        $tent->assembleView($viewContent);

        $tent->setContent();

        /*  TODO in setContent()
        *   if the campname was wrong, then error
        *   after the content is setUp, remove all open camps in the last view
        *   includes for easier partials ->later
        */

        return $tent->fullView();
    }

    public function fullView() : string {

        return end($this->viewTree)['content'] ?? '';
    }

    protected function getContent($viewPath) {
        ob_start();

        include_once($viewPath);

        return ob_get_clean();
    }

    protected function getLayout($layouts) {
        ob_start();

        foreach($layouts as $layout) {
            include_once $layout;
        }

        return ob_get_clean();
    }

    protected function assembleLayouts(string $content) {
        $layouts = [view('layouts.base')];
        //go throught content string and add all layouts needed to the view
        return $layouts;
    }

    protected function assembleView($viewContent) {
        $content = $this->getContent($viewContent);
        $extends = Str::between($content, '%extends(\'', '\')') ?? false;
        
        if($extends) {
           $content = str_replace("%extends('$extends')", null, $content);
        }
        $this->viewTree[] = ['content' => $content, 'extends' => $extends];
    
        
        return !$extends ?: $this->assembleView(view($extends));
    }

    protected function setContent() {
        foreach ($this->viewTree as $index => ['content' => &$childContent, 'extends' => $parent]) {
            
            if(!$parent) {
                break;
            }

            while($campName = Str::between($childContent, '%tent(\'', '\')') ?? false) { //name of thingy that should be in parent
                $camp = Str::between($childContent, "%tent('$campName')", '%endtent'); //what should be in parent
                $childContent = str_replace("%tent('$campName')", '', $childContent); //so that it wont loop
                $childContent = str_replace("%endtent", '', $childContent);
                //if the camp exists in parent, then exchange, otherwise error and nothing

                $this->viewTree[$index + 1]['content'] = str_replace("%camp('$campName')", $camp,  $this->viewTree[$index + 1]['content']);
            }
        }
    }
}