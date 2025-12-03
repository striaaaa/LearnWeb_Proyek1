<?php
// function createMaterPdf($modules)
// {
//     require_once "PdfHelper.php";

//     $html = "";

//     foreach ($modules as $module) {

//         // Tambah judul modul
//         $html .= "<h2>{$module->title}</h2>";

//         foreach ($module->modulesContent as $content) {

//             $data = trim($content->content_data);

//             // Skip jika kosong
//             if ($data === "") continue;

//             // CASE 1: JSON Editor.js
//             if (str_starts_with($data, "{")) {

//                 $json = json_decode($data, true);
//                 if (!$json || !isset($json['blocks'])) continue;

//                 foreach ($json['blocks'] as $b) {

//                     switch ($b['type']) {
//                         case "header":
//                             $lvl = $b['data']['level'];
//                             $text = $b['data']['text'];
//                             $html .= "<h$lvl>$text</h$lvl>";
//                             break;

//                         case "paragraph":
//                             $html .= "<p>{$b['data']['text']}</p>";
//                             break;

//                         case "list":
//                             $tag = $b['data']['style'] === "ordered" ? "ol" : "ul";
//                             $html .= "<$tag>";
//                             foreach ($b['data']['items'] as $item) {
//                                 $html .= "<li>{$item['content']}</li>";
//                             }
//                             $html .= "</$tag>";
//                             break;

//                         case "code":
//                             $code = htmlspecialchars($b['data']['code']);
//                             $html .= "<pre><code>$code</code></pre>";
//                             break;

//                         case "quote":
//                             $text = $b['data']['text'];
//                             $cap  = $b['data']['caption'];
//                             $html .= "<blockquote><p>$text</p><footer>$cap</footer></blockquote>";
//                             break;

//                         case "delimiter":
//                             $html .= "<hr>";
//                             break;
//                     }
//                 }
//             }

//             // CASE 2: Gambar
//             else if (preg_match("/\.(png|jpg|jpeg|gif)$/i", $data)) {
//                 $path = $_SERVER['DOCUMENT_ROOT'] . $data; // full path
//                 if (file_exists($path)) {
//                     $base64 = base64_encode(file_get_contents($path));
//                     $html .= "<img src='data:image/png;base64,$base64' style='max-width:100%; margin:15px 0;'>";
//                 }
//             }

//         } // end foreach modulesContent

//         $html .= "<hr>"; // pemisah antar modul
//     }

//     // WRAP HTML
//     $fullHtml = "
//     <html>
//     <head>
//     <style>
//     body { font-family: sans-serif; line-height: 1.6; }
//     h1,h2,h3 { margin-bottom: 6px; }
//     p { margin-bottom: 10px; }
//     code, pre { background:#f4f4f4; padding:8px; border-radius:4px; }
//     blockquote { border-left:4px solid #888; padding-left:10px; margin:10px 0; font-style:italic; }
//     hr { margin:30px 0; }
//     img { display:block; }
//     </style>
//     </head>
//     <body>
//     $html
//     </body>
//     </html>
//     ";

//     PdfHelper::generatePdf($fullHtml, "materi.pdf");
// } 

require_once "PdfHelper.php";

// Data dari controller kamu sebelumnya
// $modules = getModuleswithContent($course_id)['data']; 
function createMaterPdfFromModules($modules, $pdfFileName = "materi.pdf") {
    $htmlFinal = "";

    $htmlFinal .= "<h1 style='margin-top:20px;'>{$modules['courseData']->title}</h2>";
    foreach ($modules['data'] as $module) {
        $htmlFinal .= "<h2 style='margin-top:20px;'>{$module->title}</h2>";
        $contents = [];
        if (is_array($module->modulesContent)) {
            $contents = $module->modulesContent;
        } elseif (is_object($module->modulesContent)) {
            $contents = get_object_vars($module->modulesContent);
        }

        foreach ($contents as $content) {
            $data = '';
            if (is_object($content) && isset($content->content_data)) {
                $data = trim($content->content_data);
            } elseif (is_string($content)) {
                $data = trim($content);
            } else {
                continue;
            }

            if ($data === "") continue;
            $json = json_decode($data, true);
            if (is_array($json) && isset($json[0]['type'])) {
                foreach ($json as $block) {
                    switch ($block['type']) {
                        case 'paragraph':
                            $htmlFinal .= "<p>{$block['data']['text']}</p>";
                            break;
                        case 'header':
                            $lvl = $block['data']['level'];
                            $text = $block['data']['text'];
                            $htmlFinal .= "<h{$lvl}>{$text}</h{$lvl}>";
                            break;
                        case 'list':
                            $tag = ($block['data']['style'] ?? '') === 'ordered' ? 'ol' : 'ul';
                            $htmlFinal .= "<$tag>";
                            foreach ($block['data']['items'] ?? [] as $item) {
                                $htmlFinal .= "<li>{$item['content']}</li>";
                            }
                            $htmlFinal .= "</$tag>";
                            break;
                        case 'code':
                            $code = htmlspecialchars($block['data']['code']);
                            $htmlFinal .= "<pre><code>$code</code></pre>";
                            break;
                        case 'quote':
                            $text = $block['data']['text'] ?? '';
                            $cap  = $block['data']['caption'] ?? '';
                            $htmlFinal .= "<blockquote><p>$text</p><footer>$cap</footer></blockquote>";
                            break;
                        case 'delimiter':
                            $htmlFinal .= "<hr>";
                            break;
                    }
                }
            }
            elseif (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $data)) {
                $htmlFinal .= "<img src='$data' style='max-width:100%; margin:10px 0;'>";
            }
            else {
                $htmlFinal .= "<p>$data</p>";
            }
        }  
    } // end foreach module
 
    // var_dump($htmlFinal);
    // die;
    $fullHtml = "
    <html>
    <head>
    <style>
    body { font-family: sans-serif; line-height:1.5; }
    h1,h2,h3 { margin-bottom:6px; }
    p { margin-bottom:10px; }
    code, pre { background:#f4f4f4; padding:8px; border-radius:4px; }
    blockquote { border-left:4px solid #888; padding-left:10px; margin:10px 0; font-style:italic; }
    hr { margin:20px 0; }
    img { max-width:100%; }
    </style>
    </head>
    <body>
    $htmlFinal
    </body>
    </html>
    ";

    PdfHelper::generatePdf($fullHtml, $pdfFileName);
}

