<?php

namespace Views;

class Renderer
{
    public static function render(
        $vista,
        $datos,
        $layoutFile = "layout.view.tpl",
        $render = true
    ) {
        if (!is_array($datos)) {
            http_response_code(404);
            die("Error de renderizador: datos no es un arreglo");
        }

        $global_context = \Utilities\Context::getContext();
        if (is_array($global_context)) {
            $datos = array_merge($global_context, $datos);
        }
        $datos = array_merge($_SESSION, $datos);
        if (isset($datos["layoutFile"]) && $layoutFile === "layout.view.tpl") {
            $layoutFile = $datos["layoutFile"];
        }
        if (strpos($layoutFile, ".view.tpl") === false) {
            $layoutFile .= ".view.tpl";
        }

        $viewsPath = "src/Views/templates/";
        $fileTemplate = $vista . ".view.tpl";
        $htmlContent = "";
        if (file_exists($viewsPath . $layoutFile)) {
            $htmlContent = file_get_contents($viewsPath . $layoutFile);
            if (file_exists($viewsPath . $fileTemplate)) {
                $tmphtml = file_get_contents($viewsPath . $fileTemplate);
                $htmlContent = str_replace(
                    "{{{page_content}}}",
                    $tmphtml,
                    $htmlContent
                );
                if(strpos($htmlContent, "{{include")){
                    $htmlContent = self::loadPartials($htmlContent);
                }
                if (strpos($htmlContent, "<pre>")) {
                } else {
                    $htmlContent = str_replace("\n", "", $htmlContent);
                    $htmlContent = str_replace("\r", "", $htmlContent);
                    $htmlContent = str_replace("\t", "", $htmlContent);
                    $htmlContent = str_replace("  ", "", $htmlContent);
                }
                $template_code = self::_parseTemplate($htmlContent);
                $htmlResult = self::_renderTemplate($template_code, $datos);

                if ($render) {
                    if($datos["USE_URLREWRITE"] == "1") {
                        echo self::rewriteUrl($htmlResult);
                    } else {
                        echo $htmlResult;
                    }
                } else {
                    return $htmlResult;
                }
            } else {
                http_response_code(404);
                die("Plantilla no encontrada: " . $fileTemplate);
            }
        } else {
            http_response_code(404);
            die("Layout no encontrado: " . $layoutFile);
        }
    }

    protected static function loadPartials($htmlContent)
    {
        $pattern = '/{{include\s+([^}]+)}}/';
        preg_match_all($pattern, $htmlContent, $matches);
        if (isset($matches[1])) {
            foreach ($matches[1] as $file) {
                $file = trim($file);
                $viewsPath = "src/Views/templates/";
                $filePath = $viewsPath . $file . ".view.tpl";
                if (file_exists($filePath)) {
                    $content = file_get_contents($filePath);
                    $htmlContent = str_replace("{{include " . $file . "}}", $content, $htmlContent);
                }
            }
        }
        return $htmlContent;
    }

    protected static function _parseTemplate($template)
    {
        $template = str_replace("\n", "", $template);
        $template = str_replace("\r", "", $template);
        return $template;
    }

    protected static function _renderTemplate($template_code, $datos)
    {
        $template_code = self::_renderLoops($template_code, $datos);
        $template_code = self::_renderConditionals($template_code, $datos);
        $template_code = self::_renderVariables($template_code, $datos);
        return $template_code;
    }

    protected static function _renderVariables($template, $datos)
    {
        // Primera pasada: Variables con propiedades $var->prop
        $template = preg_replace_callback('/\{\{\s*\$([a-zA-Z_][a-zA-Z0-9_]*)\s*->\s*([a-zA-Z_][a-zA-Z0-9_]*)\s*\}\}/', 
            function($m) use ($datos) {
                $varName = $m[1];
                $propName = $m[2];
                if (isset($datos[$varName]) && is_object($datos[$varName])) {
                    $obj = $datos[$varName];
                    if (isset($obj->$propName)) {
                        return $obj->$propName;
                    }
                }
                return '';
            },
            $template
        );
        
        // Segunda pasada: Variables simples {{var}}
        $template = preg_replace_callback('/\{\{\s*([a-zA-Z_][a-zA-Z0-9_]*)\s*\}\}/', 
            function($m) use ($datos) {
                $varName = $m[1];
                if (isset($datos[$varName])) {
                    $val = $datos[$varName];
                    if (is_scalar($val)) {
                        return $val;
                    } elseif (is_array($val) || is_object($val)) {
                        return json_encode($val);
                    }
                }
                return '';
            },
            $template
        );
        
        return $template;
    }

    protected static function _renderConditionals($template, $datos)
    {
        $pattern = '/\{\{if\s+(\$?[a-zA-Z_][a-zA-Z0-9_]*)\}\}(.*?)\{\{\/if\}\}/s';
        $template = preg_replace_callback($pattern, function ($matches) use ($datos) {
            $condition = trim($matches[1]);
            $content = $matches[2];
            if (isset($datos[$condition]) && $datos[$condition]) {
                return $content;
            }
            return "";
        }, $template);
        return $template;
    }

    protected static function _renderLoops($template, $datos)
    {
        $pattern = '/\{\{foreach\s+(\$?[a-zA-Z_][a-zA-Z0-9_]*)\s+as\s+\$?([a-zA-Z_][a-zA-Z0-9_]*)\}\}(.*?)\{\{\/foreach\}\}/s';
        $template = preg_replace_callback($pattern, function ($matches) use ($datos) {
            $array_name = trim($matches[1]);
            $item_name = trim($matches[2]);
            $content = $matches[3];

            if (!isset($datos[$array_name])) {
                return "";
            }

            $output = "";
            $array = $datos[$array_name];
            if (is_array($array) || ($array instanceof \Iterator)) {
                foreach ($array as $item) {
                    // Copiar todos los datos y agregar el item actual
                    $item_datos = $datos;
                    $item_datos[$item_name] = $item;
                    
                    // Si el item es un objeto, agregar sus propiedades como variables
                    if (is_object($item)) {
                        foreach (get_object_vars($item) as $prop => $value) {
                            $item_datos[$prop] = $value;
                        }
                    }
                    
                    $rendered = self::_renderVariables($content, $item_datos);
                    $rendered = self::_renderConditionals($rendered, $item_datos);
                    $output .= $rendered;
                }
            }
            return $output;
        }, $template);
        return $template;
    }

    public static function rewriteUrl($url)
    {
        $base_dir = \Utilities\Context::getContextByKey("BASE_DIR");
        $url = str_replace("index.php?page=", $base_dir, $url);
        return $url;
    }
}
?>
