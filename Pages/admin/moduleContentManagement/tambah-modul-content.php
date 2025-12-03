<?php
require_once __DIR__ . '/../../../controller/moduleManajemenController.php';
require_once __DIR__ . '/../../../controller/uploadController.php';
$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
global $params;
$module_content_id = $_GET['module_content_id'] ?? 1;
$idModule = $params['moduleId'] ?? null;
// echo $idModule;

$getDrafData = getDraft($idModule);
// echo $id;
$finalDataDraft = getFinalModule($idModule);


?>


<style>
  .editor-wrapper {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;

  }

  .element-sidebar {
    background-color: #ddd;
    padding: 20px;
    border-radius: 16px;
  }

  .editor-parent {
    border-radius: 16px;
    padding: 20px;
    background-color: #ffffff;

  }

  .tambah-elemnt-btn {
    width: 100%;
    padding: 10px 0px;
    border: none;
    background-color: transparent;
    border-bottom: 2px solid gray;
  }

  .btn-content p {
    font-size: 16px;
    font-weight: 400;
  }
</style>
<div class="h-full">
  <div class="grid grid-cols-12 gap-4 h-full">
    <div class="col-span-3 element-sidebar">
      <div style="position: sticky;top:0;">
        <h2>Tambah modul konten</h1>
          <p>Lorem ipsum dolor sit amet consectetur.</p>
          <input type="text" placeholder="Cari">
          <div>
            <h2>Tambah element</h2>
            <div>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('header')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Heading</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('image')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Image</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('list')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>List</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('code')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Code</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('linkTool')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Link</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('delimiter')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Delimiter</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
              <button class="tambah-elemnt-btn flex justify-between" onclick="addBlock('chunkDivider')">
                <div class="flex items-center btn-content">
                  <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                    <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
                  </svg>
                  &nbsp;
                  &nbsp;
                  <h2>
                    <p>Chunk Poin</p>
                  </h2>
                </div>
                <p>+</p>
              </button>
            </div>
          </div>
      </div>
    </div>
    <div class="col-span-9 editor-parent h" style="position: relative;">
      <div id="editorjs" class="h-full"></div>
      <form action="<?= basefolder() ?>/controller/manajemenContentController.php" method="post">

        <div style="position: sticky;bottom:0;" class="flex justify-end">
          <input type="hidden" name="module_id" value="<?= $idModule ?>">
          <button class="" id="save-button" name='action' value='addOrUpdateModuleContent'>Simpan</button>
        </div>
      </form>
    </div>
  </div>
  <pre id="output"></pre>
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
  const backup = localStorage.getItem('editorBackup');
  const initialData = backup ? JSON.parse(backup) : {
    blocks: []
  };
  let lastImages = []; 
  class ChunkDivider {
    static get toolbox() {
      return {
        title: 'Chunk',
        icon: '<svg width="18" height="18" xmlns="http://www.w3.org/2000/svg"><path d="M2 9h14v1H2z" fill="currentColor"/></svg>'
      };
    }

    render() {
      this.wrapper = document.createElement('div');
      this.wrapper.classList.add('chunk-divider');
      this.wrapper.innerHTML = `
      <div style="border-top: 2px dashed #aaa; margin: 20px 0; text-align:center; font-size: 12px; color:#888;">
        — CHUNK PEMBATAS —
      </div>
    `;
      return this.wrapper;
    }

    save() {
      return {
        type: 'chunk'
      }; // data JSON-nya minimal
    }
  }
  const editor = new EditorJS({
    holder: 'editorjs',
    autofocus: true,
    tools: {

      header: Header,
      paragraph: {
        inlineToolbar: true
      },
      list: EditorjsList,
      quote: Quote,
      code: CodeTool,
      delimiter: Delimiter,
      chunkDivider: ChunkDivider,
      // image: {
      //   class: ImageTool,
      //   config: {
      //     endpoints: { byFile: '/upload-image.php', byUrl: '/fetch-image.php' }
      //   }
      // },
      image: {
        class: ImageTool,
        config: {
          endpoints: {
            byFile: '<?= basefolder(); ?>/controller/uploadController.php?action=upload-image',
            byUrl: '<?= basefolder(); ?>/controller/uploadController.php?action=fetch-image'
          }
        }
      },
      linkTool: {
        class: LinkTool,
        config: {
          endpoint: '/fetch-link.php'
        }
      }
    },
      async onChange(api, event) {
          console.log('ini api',api);    
        console.log('ini event',event);
        // const output = await api.saver.save(); 
        // const newImages = extractImageUrls(output); 
        // const deleted = lastImages.filter(url => !newImages.includes(url)); 
        // if (deleted.length > 0) { 
        //     deleted.forEach(img => deleteImageFromServer(img));
        // } 
        // lastImages = newImages;
    },
    data: initialData,
    onReady: async () => {
      console.log('EditorJS siap.');
      await loadDraftygPertama(); // di sini aman panggil render
    }

  });
function deleteImageFromServer(url) {
    fetch('/controller/uploadController.php?action=delete-image', {
        method: 'POST',
        body: new FormData().append('url', url)
    });
}

  function addBlock(type) {
    editor.save().then(() => {
      const lastIndex = editor.blocks.getBlocksCount(); 
      switch (type) {
        case 'header':
          editor.blocks.insert('header', {
            text: 'Judul baru',
            level: 2
          }, null, lastIndex, true);
          break;
        case 'paragraph':
          editor.blocks.insert('paragraph', {
            text: 'Mulai menulis paragraf di sini...'
          }, null, lastIndex, true);
          break;
        case 'list':
          editor.blocks.insert('list', {
            style: 'unordered',
            items: ['Item 1', 'Item 2']
          }, null, lastIndex, true);
          break;
        case 'quote':
          editor.blocks.insert('quote', {
            text: 'Tuliskan kutipan...',
            caption: 'Penulis'
          }, null, lastIndex, true);
          break;
        case 'code':
          editor.blocks.insert('code', {
            code: '// kode di sini'
          }, null, lastIndex, true);
          break;
        case 'delimiter':
          editor.blocks.insert('delimiter', {}, null, lastIndex, true);
          break;
        case 'image':
          editor.blocks.insert('image', {
            file: {
              url: '/placeholder.png'
            },
            caption: 'Contoh gambar'
          }, null, lastIndex, true);
          break;
        case 'linkTool':
          editor.blocks.insert('linkTool', {
            link: 'https://example.com'
          }, null, lastIndex, true);
          break;
        case 'chunkDivider':
          editor.blocks.insert('chunkDivider', {}, null, lastIndex, true);
          break;
        default:
          console.warn('Tipe blok tidak dikenal:', type);
      }
    });
  }
  document.getElementById('save-button').addEventListener('click', () => {
    editor.save().then(data => {
      document.getElementById('output').innerHTML = JSON.stringify(data, null, 4);
    });
  });


  // setInterval(async () => {
  //   const  Data = await editor.save();
  //   localStorage.setItem('editorBackup', JSON.stringify(savedData));
  //   console.log('Editor data saved to localStorage');
  // }, 3000);
  // const res = await fetch('<?= basefolder() ?>/controller/uploadController.php?action=getDraft&module_content_id=1&module_id=10');
  // const data = await res.json();

  // if (data.success && data.data) {
  //   console.log('Draft ditemukan, render ke editor...');
  //   await editor.render(data.data);
  // } 

  // biar gaa lupa
  // buattag
  async function loadDraft() {

    const draftData = <?= json_encode(
                        $getDrafData ?? null,
                        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
                      ); ?>;
   if (draftData && draftData.data) {
    window.lastServerVersion = draftData.data.last_updated_server;
    await editor.render(draftData.data.content);
} else {
      console.log('Tidak ada draft tersimpan.');
    }
  }
  async function loadDraft2() {

    const draftData = <?= json_encode(
                        $finalDataDraft ?? null,
                        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
                      ); ?>;
    if (draftData) {
      // console.log('Draft ditemukan, render langsung tanpa fetch...');
      console.log('inidrat', draftData.data);
      await editor.render(draftData.data);

    } else {
      console.log('Tidak ada draft tersimpan.');
    }
  }
  // loadDraft();
  async function loadDraftygPertama() {
  // const res = await fetch('<?=basefolder()?>/controller/uploadController.php?action=getDraft&module_content_id=1&module_id=10');
  // const data = await res.json();

  // if (data.success && data.data) {
  //   console.log('Draft ditemukan, render ke editor...');
  //   await editor.render(data.data);
  // } 
   
  // biar gaa lupa
  // buattag

const draftData = <?= json_encode(
    $getDrafData ?? null,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
); ?>; 


  if (draftData) {
    // console.log('Draft ditemukan, render langsung tanpa fetch...');
    console.log('inidrat',draftData.data);
    await editor.render(draftData.data);
    
  } else {
    console.log('Tidak ada draft tersimpan.');
  }
}

// interval awal
  setInterval(async () => {
  const savedData = await editor.save();
  console.log('p',savedData);
  // localStorage.setItem('editorBackup', JSON.stringify(savedData));
 fetch('<?=basefolder()?>/controller/uploadController.php?action=autosave', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ 
      module_id: <?=$idModule?>,
      content: savedData
    })
  })
  .then(res => res.json())
  .then(res => console.log(res.message));
  // console.log(savedData);
}, 3000);
// setInterval(async () => {
//     const savedData = await editor.save();

//     fetch('<?=basefolder()?>/controller/uploadController.php?action=autosave', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({
//             module_id: <?= $idModule ?>,
//             content: savedData,
//             client_last_update: window.lastServerVersion
//         })
//     })
//     .then(res => res.json())
//     .then(res => {
//         if (res.conflict) {
//             console.warn("Conflict detected!"); 
//             const latest = res.latest; 
//             editor.render(latest.content); 
//             window.lastServerVersion = latest.last_updated_server;
//             return;
//         }
//         window.lastServerVersion = res.last_updated_server;
//         console.log("Autosaved", res);
//     })
//     .catch(err => console.error(err));
// }, 3000);


</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>