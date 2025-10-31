<?php
require_once __DIR__ . '/../../../controller/moduleManajemenController.php';
$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
global $params;
$id = $params['moduleId'] ?? null;
$content = '{
    "time": 1761672877417,
    "blocks": [
        {
            "id": "Elbs3AsH8W",
            "type": "header",
            "data": {
                "text": "Mulai menulis modul Anda di sini",
                "level": 2
            }
        },
        {
            "id": "v6z4YHCKju",
            "type": "header",
            "data": {
                "text": "Sub Judul Modul",
                "level": 3
            }
        },
        {
            "id": "L7RQjvx1v2",
            "type": "paragraph",
            "data": {
                "text": "Editor ini sudah mendukung heading, list, quote, image, dan code block dengan tampilan yang rapi dan responsif."
            }
        },
        {
            "id": "abc123",
            "type": "list",
            "data": {
                "style": "ordered",
                "items": [
                    "Gunakan heading untuk membuat struktur dokumen",
                    "Tambahkan gambar untuk memperjelas materi",
                    "Gunakan code block untuk menampilkan potongan kode"
                ]
            }
        },
        {
            "id": "img001",
            "type": "image",
            "data": {
                "file": { "url": "https://placekitten.com/600/300" },
                "caption": "Contoh gambar kucing lucu"
            }
        },
        {
            "id": "quote01",
            "type": "quote",
            "data": {
                "text": "Belajar bukan soal cepat, tapi soal konsisten.",
                "caption": "Anonim"
            }
        },
        {
            "id": "DCYautW9iG",
            "type": "delimiter",
            "data": {}
        },
        {
            "id": "H7yU1TMAk6",
            "type": "paragraph",
            "data": {
                "text": "Itulah contoh hasil tampilan dari EditorJS yang sudah dikonversi ke HTML menggunakan JavaScript."
            }
        }
    ],
    "version": "2.31.0"
}';
?>
<?php
/**
 * Render semua blok EditorJS ke HTML
 * Support: header, paragraph, list, quote, code, image, delimiter, embed (YouTube/Twitter)
 */

function renderEditorJS($jsonData)
{
    if (is_string($jsonData)) {
        $data = json_decode($jsonData, true);
    } else {
        $data = $jsonData;
    }

    if (!isset($data['blocks'])) return '';

    $html = '';

    foreach ($data['blocks'] as $block) {
        $type = $block['type'];
        $content = $block['data'];

        switch ($type) {
            // === HEADER ===
            case 'header':
                $level = isset($content['level']) ? max(1, min(6, (int)$content['level'])) : 2;
                $text = htmlspecialchars($content['text'] ?? '');
                $html .= "<h{$level}>{$text}</h{$level}>\n";
                break;

            // === PARAGRAPH ===
            case 'paragraph':
                $text = htmlspecialchars($content['text'] ?? '');
                $html .= "<p>{$text}</p>\n";
                break;

            // === LIST ===
            case 'list':
                $style = ($content['style'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
                $items = $content['items'] ?? [];

                $html .= "<{$style}>\n";
                foreach ($items as $item) {
                    // Nested list (jika item berupa array)
                    if (is_array($item)) {
                        $html .= "<li>";
                        $html .= htmlspecialchars($item['content'] ?? '');
                        if (isset($item['items'])) {
                            $html .= renderNestedList($item['items'], $style);
                        }
                        $html .= "</li>\n";
                    } else {
                        $html .= "<li>" . htmlspecialchars($item) . "</li>\n";
                    }
                }
                $html .= "</{$style}>\n";
                break;

            // === QUOTE ===
            case 'quote':
                $text = htmlspecialchars($content['text'] ?? '');
                $caption = htmlspecialchars($content['caption'] ?? '');
                $html .= "<blockquote><p>{$text}</p><cite>{$caption}</cite></blockquote>\n";
                break;

            // === CODE ===
            case 'code':
                $code = htmlspecialchars($content['code'] ?? '');
                $html .= "<pre><code>{$code}</code></pre>\n";
                break;

            // === IMAGE ===
            case 'image':
                $url = htmlspecialchars($content['file']['url'] ?? $content['url'] ?? '');
                $caption = htmlspecialchars($content['caption'] ?? '');
                $html .= "<figure><img src='{$url}' alt=''><figcaption>{$caption}</figcaption></figure>\n";
                break;

            // === DELIMITER ===
            case 'delimiter':
                $html .= "<hr />\n";
                break;

            // === EMBED (YouTube / Twitter / dst) ===
            case 'embed':
                $service = $content['service'] ?? '';
                $embed = htmlspecialchars($content['embed'] ?? '');
                $caption = htmlspecialchars($content['caption'] ?? '');

                if ($service === 'youtube') {
                    $html .= "<div class='embed-youtube'>
                        <iframe width='560' height='315' src='{$embed}' frameborder='0' allowfullscreen></iframe>
                        <p>{$caption}</p></div>\n";
                } elseif ($service === 'twitter') {
                    $html .= "<blockquote class='twitter-tweet'><a href='{$embed}'></a></blockquote>\n";
                } else {
                    $html .= "<div class='embed-generic'>
                        <iframe src='{$embed}' frameborder='0'></iframe>
                        <p>{$caption}</p></div>\n";
                }
                break;

            default:
                $html .= "<!-- Unsupported block: {$type} -->\n";
                break;
        }
    }

    return $html;
}

/**
 * Fungsi bantu untuk nested list
 */
function renderNestedList($items, $parentStyle = 'ul')
{
    $html = "<{$parentStyle}>\n";
    foreach ($items as $subItem) {
        if (is_array($subItem)) {
            $html .= "<li>" . htmlspecialchars($subItem['content'] ?? '');
            if (isset($subItem['items'])) {
                $html .= renderNestedList($subItem['items'], $parentStyle);
            }
            $html .= "</li>\n";
        } else {
            $html .= "<li>" . htmlspecialchars($subItem) . "</li>\n";
        }
    }
    $html .= "</{$parentStyle}>\n";
    return $html;
}
?> 
<?php  
// $editorData=[];
$editorData = [
    "time" => 1761672877417,
    "blocks" => [
        ["type" => "header", "data" => ["text" => "Judul H1", "level" => 1]],
        ["type" => "header", "data" => ["text" => "Subjudul H3", "level" => 3]],
        ["type" => "paragraph", "data" => ["text" => "Ini paragraf pembuka dari artikel yang dibuat menggunakan EditorJS."]],
        ["type" => "list", "data" => [
            "style" => "ordered",
            "items" => [
                "Langkah pertama lakukan inisialisasi proyek",
                ["content" => "Langkah kedua persiapkan struktur folder", "items" => [
                    "Folder assets",
                    "Folder controller",
                    "Folder views"
                ]],
                "Langkah ketiga jalankan server lokal"
            ]
        ]],
        ["type" => "delimiter", "data" => []],
        ["type" => "quote", "data" => ["text" => "Kesederhanaan adalah kunci elegansi sejati.", "caption" => "Coco Chanel"]],
        ["type" => "code", "data" => ["code" => "<?php echo 'Hello World'; ?>"]],
        ["type" => "image", "data" => [
            "file" => ["url" => "https://placehold.co/600x300"],
            "caption" => "Contoh gambar placeholder"
        ]],
        ["type" => "embed", "data" => [
            "service" => "youtube",
            "embed" => "https://www.youtube.com/embed/dQw4w9WgXcQ",
            "caption" => "Video tutorial lengkap"
        ]]
    ],
    "version" => "2.31.0"
];

echo renderEditorJS($editorData);
?>


<!-- 🧪 Contoh pemakaian -->
<?php
$editorData = [
    "time" => 1761672877417,
    "blocks" => [
        ["type" => "header", "data" => ["text" => "Judul Utama", "level" => 1]],
        ["type" => "header", "data" => ["text" => "Judul Utama", "level" => 3]],
        ["type" => "paragraph", "data" => ["text" => "Ini paragraf pertama modul Anda."]],
        ["type" => "list", "data" => ["style" => "unordered", "items" => ["Item satu", "Item dua", "Item tiga"]]],
        ["type" => "delimiter", "data" => []],
        ["type" => "quote", "data" => ["text" => "Belajar seumur hidup adalah kunci sukses.", "caption" => "Anonim"]],
    ],
    "version" => "2.31.0"
];

echo renderEditorJS($editorData);
?>


<style>
    .editor-wrapper {
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
    }
</style>

  <h2>Hasil Render:</h2>
  <div id="output"></div>
<div>
    <h1>Preview Modul</h1>
  <div id="moduleContent">Memuat konten...</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/@bomdi/editorjs-html@latest/dist/index.umd.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/editorjs-parser@1/build/Parser.browser.min.js"></script>
<script>
  // setelah library di-load
  const data = {
  "time": 1761672877417,
  "blocks": [
    { "type": "header", "data": { "text": "Mulai menulis modul Anda di sini", "level": 2 } },
    { "type": "header", "data": { "text": "Sub Judul", "level": 1 } },
    { "type": "paragraph", "data": { "text": "…"} }
    // … dst
  ],
  "version": "2.31.0"
};

  const parser = new edjsParser(); // tanpa argumen jika pakai default
  const htmlArray = parser.parse(data);
  document.getElementById("moduleContent").innerHTML = htmlArray.join('');
</script>


</div>
<div class="editor-wrapper" style="padding:20px; max-width:800px; margin:auto;">
  <h2>Editor Modul ID: <?= htmlspecialchars($id) ?></h2>
  <div id="editorjs"></div>
  <div style="margin-top:20px;">
    <button id="save-button">💾 Save</button>
  </div>
  <pre id="output" style="margin-top:20px; background:#f4f4f4; padding:10px;"></pre>
</div>

<!-- CDN JS -->
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>

<script>
  const editor = new EditorJS({
    holder: 'editorjs',
    autofocus: true,
    tools: {
      header: {
        class: Header,
        inlineToolbar: true,
        config: {
          placeholder: 'Enter a header',
          levels: [1,2, 3, 4],
          defaultLevel: 2
        }
      },
      paragraph: {
        inlineToolbar: true
      },
      list: {
        class: EditorjsList,
        inlineToolbar: true,
        config: {
          defaultStyle: 'unordered'
        }
      },
      quote: {
        class: Quote,
        inlineToolbar: true,
        config: {
          quotePlaceholder: 'Enter a quote',
          captionPlaceholder: 'Quote author'
        }
      },
      code: {
        class: CodeTool,
        inlineToolbar: false
      },
      delimiter: Delimiter,
      image: {
        class: ImageTool,
        config: {
          endpoints: {
            byFile: '/upload-image.php', // endpoint upload file
            byUrl: '/fetch-image.php'    // endpoint fetch dari URL
          },
          captionPlaceholder: 'Enter caption...',
          additionalRequestHeaders: {},
          field: 'image'
        }
      },
      linkTool: {
        class: LinkTool,
        config: {
          endpoint: '/fetch-link.php' // endpoint untuk meta link
        }
      }
    },
    data: {
      time: new Date().getTime(),
      blocks: [
        {
          type: "header",
          data: { text: "Mulai menulis modul Anda di sini", level: 2 }
        },
        {
          type: "paragraph",
          data: { text: "Editor ini sudah mendukung heading, list, quote, image, dan code block." }
        },
        {
          type: "delimiter",
          data: {}
        }
      ]
    }
  });

  const saveButton = document.getElementById('save-button');
  const output = document.getElementById('output');

  saveButton.addEventListener('click', () => {
    editor.save().then(savedData => {
      output.innerHTML = JSON.stringify(savedData, null, 4);
      console.log(savedData);
      // TODO: kirim ke backend pakai fetch() untuk disimpan ke DB
    }).catch((error) => {
      console.error('Saving failed: ', error);
    });
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>
