<?php
require_once __DIR__ . '/../../../controller/moduleManajemenController.php';
$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
global $params;
$id = $params['moduleId'] ?? null;

?> 


<style>
    .editor-wrapper {
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
    }
    .element-sidebar{
      background-color: #ddd;
      padding: 20px;
      border-radius: 16px;
    }
    .editor-parent{
      border-radius: 16px;
      padding: 20px;
      background-color: #ffffff;
    }
    .tambah-elemnt-btn{
      width: 100%;
      padding: 10px 0px;
      border: none;
      background-color: transparent;
      border-bottom:2px solid gray ;
    }
    .btn-content{
      
      font-weight: 400 ;
    }
</style> 
<div>
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-3 element-sidebar">
      <div>
        <h1>Tambah modul konten</h1>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
        <input type="text" placeholder="Cari">
        <div>
          <h2>Tambah element</h2>
          <div>
            <button class="tambah-elemnt-btn flex justify-between">
              <div class="flex items-center btn-content">

                <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                  <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                </svg>
                &nbsp; 
                <h2>

                  Heading
                </h2>
              </div>
        <span>+</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-9 editor-parent">

    </div>
  </div>
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
